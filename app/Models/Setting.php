<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    // ── Static Helpers ──

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting?->value ?? $default;
        });
    }

    public static function set(string $key, mixed $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget("setting.{$key}");
        Cache::forget('settings.all');
    }

    public static function getMultiple(array $keys): array
    {
        // Check which keys are already cached
        $results = [];
        $missingKeys = [];

        foreach ($keys as $key) {
            $cached = Cache::get("setting.{$key}");
            if ($cached !== null) {
                $results[$key] = $cached;
            } else {
                $missingKeys[] = $key;
            }
        }

        // Fetch all missing keys in a single query
        if (!empty($missingKeys)) {
            $fetched = static::whereIn('key', $missingKeys)->pluck('value', 'key');

            foreach ($missingKeys as $key) {
                $value = $fetched[$key] ?? null;
                Cache::put("setting.{$key}", $value, 3600);
                $results[$key] = $value;
            }
        }

        return $results;
    }

    public static function getByGroup(string $group): array
    {
        return Cache::remember("settings.group.{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function clearCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
        Cache::forget('settings.all');
    }

    // ── Scopes ──

    public function scopeByGroup(Builder $query, string $group): Builder
    {
        return $query->where('group', $group);
    }

    // ── PPDB Helpers ──

    public static function isPpdbOpen(): bool
    {
        $isOpen = static::get('is_ppdb_open', '0');
        if ($isOpen !== '1') {
            return false;
        }

        $startDate = static::get('ppdb_start_date');
        $endDate = static::get('ppdb_end_date');

        if ($startDate && now()->lt($startDate)) {
            return false;
        }

        if ($endDate && now()->gt($endDate)) {
            return false;
        }

        return true;
    }
}

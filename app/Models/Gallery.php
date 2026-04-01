<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'album',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    // ── Scopes ──

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order')->orderByDesc('created_at');
    }

    public function scopeByAlbum(Builder $query, string $album): Builder
    {
        return $query->where('album', $album);
    }

    // ── Accessors ──

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }

    // ── Static helpers ──

    public static function albums(): array
    {
        return static::whereNotNull('album')
            ->distinct()
            ->pluck('album')
            ->sort()
            ->values()
            ->toArray();
    }
}

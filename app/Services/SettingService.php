<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }

    public function set(string $key, mixed $value, string $group = 'general'): void
    {
        Setting::set($key, $value, $group);
    }

    public function getMultiple(array $keys): array
    {
        return Setting::getMultiple($keys);
    }

    public function getSchoolInfo(): array
    {
        return Setting::getMultiple([
            'school_name',
            'address',
            'phone',
            'email',
            'logo_path',
            'principal_name',
            'principal_photo',
            'google_maps_embed',
        ]);
    }

    public function getPpdbInfo(): array
    {
        return Setting::getMultiple([
            'is_ppdb_open',
            'ppdb_start_date',
            'ppdb_end_date',
        ]);
    }

    public function getAboutInfo(): array
    {
        return Setting::getMultiple([
            'vision',
            'mission',
            'history',
            'principal_name',
            'principal_photo',
        ]);
    }

    public function clearCache(): void
    {
        Setting::clearCache();
    }
}

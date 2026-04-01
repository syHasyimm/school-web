<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected array $categories = [
        'Kegiatan Sekolah',
        'Prestasi',
        'Pengumuman',
        'Akademik',
        'Ekstrakulikuler',
        'Info PPDB',
        'Berita Umum',
        'Kesehatan',
    ];

    protected int $categoryIndex = 0;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement($this->categories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}

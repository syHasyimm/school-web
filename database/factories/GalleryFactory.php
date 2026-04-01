<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    protected array $albums = [
        'Kegiatan Belajar',
        'Upacara',
        'Olahraga',
        'Pramuka',
        'Perayaan HUT RI',
        'Wisuda',
        'Kunjungan',
        null,
    ];

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(3, 6)),
            'description' => fake()->boolean(60) ? fake()->paragraph() : null,
            'image_path' => 'galleries/placeholder-' . fake()->numberBetween(1, 10) . '.jpg',
            'album' => fake()->randomElement($this->albums),
            'order' => fake()->numberBetween(0, 20),
        ];
    }
}

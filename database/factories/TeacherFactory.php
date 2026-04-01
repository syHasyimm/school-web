<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected array $positions = [
        'Kepala Sekolah',
        'Wakil Kepala Sekolah',
        'Guru Kelas 1',
        'Guru Kelas 2',
        'Guru Kelas 3',
        'Guru Kelas 4',
        'Guru Kelas 5',
        'Guru Kelas 6',
        'Guru PAI',
        'Guru PJOK',
        'Guru Bahasa Inggris',
        'Tata Usaha',
        'Pustakawan',
        'Penjaga Sekolah',
    ];

    protected array $subjects = [
        'Matematika',
        'Bahasa Indonesia',
        'IPA',
        'IPS',
        'PKn',
        'Seni Budaya',
        'Pendidikan Agama Islam',
        'PJOK',
        'Bahasa Inggris',
        'Bahasa Daerah',
        null,
    ];

    public function definition(): array
    {
        return [
            'nip' => fake()->boolean(70) ? fake()->unique()->numerify('##################') : null,
            'full_name' => fake()->name(),
            'position' => fake()->randomElement($this->positions),
            'subject' => fake()->randomElement($this->subjects),
            'phone' => fake()->phoneNumber(),
            'photo_path' => null,
            'order' => fake()->numberBetween(0, 20),
            'is_active' => fake()->boolean(90),
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}

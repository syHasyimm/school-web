<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Settings
        $this->call(SettingsSeeder::class);

        // 2. Admin user
        $admin = User::factory()->admin()->create([
            'name' => 'Administrator',
            'email' => 'admin@sdn001.sch.id',
        ]);

        // 3. Sample teachers
        Teacher::factory(12)->active()->create();

        // 4. Categories
        $categories = collect([
            'Kegiatan Sekolah',
            'Prestasi',
            'Pengumuman',
            'Akademik',
            'Ekstrakulikuler',
        ])->map(fn ($name) => Category::factory()->create(['name' => $name]));

        // 5. Published posts
        Post::factory(10)->published()->create(['author_id' => $admin->id])
            ->each(function (Post $post) use ($categories) {
                $post->categories()->attach(
                    $categories->random(rand(1, 2))->pluck('id')
                );
            });

        // 6. Draft posts
        Post::factory(3)->draft()->create(['author_id' => $admin->id]);

        // 7. Gallery
        Gallery::factory(12)->create();
    }
}

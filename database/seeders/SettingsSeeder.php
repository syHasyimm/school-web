<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'school_name', 'value' => 'SDN 001 Kepenuhan', 'group' => 'general'],
            ['key' => 'address', 'value' => 'Jl. Pendidikan No. 1, Kec. Kepenuhan, Kab. Rokan Hulu, Riau', 'group' => 'general'],
            ['key' => 'phone', 'value' => '(0762) 123456', 'group' => 'general'],
            ['key' => 'email', 'value' => 'info@sdn001kepenuhan.sch.id', 'group' => 'general'],
            ['key' => 'logo_path', 'value' => null, 'group' => 'general'],
            ['key' => 'google_maps_embed', 'value' => null, 'group' => 'general'],

            // Principal
            ['key' => 'principal_name', 'value' => 'Nama Kepala Sekolah', 'group' => 'principal'],
            ['key' => 'principal_photo', 'value' => null, 'group' => 'principal'],

            // About
            ['key' => 'vision', 'value' => 'Terwujudnya peserta didik yang beriman, bertakwa, berakhlak mulia, cerdas, terampil, dan berwawasan lingkungan.', 'group' => 'about'],
            ['key' => 'mission', 'value' => "1. Meningkatkan keimanan dan ketakwaan kepada Tuhan Yang Maha Esa\n2. Meningkatkan kualitas pembelajaran yang aktif, kreatif, efektif, dan menyenangkan\n3. Mengembangkan potensi peserta didik secara optimal\n4. Membudayakan hidup bersih, sehat, dan peduli lingkungan\n5. Menjalin kerjasama yang harmonis dengan masyarakat", 'group' => 'about'],
            ['key' => 'history', 'value' => 'SDN 001 Kepenuhan adalah sekolah dasar negeri yang berlokasi di Kecamatan Kepenuhan, Kabupaten Rokan Hulu, Provinsi Riau. Sekolah ini telah berdiri sejak tahun 1980 dan terus berkomitmen memberikan pendidikan berkualitas bagi generasi penerus bangsa.', 'group' => 'about'],

            // PPDB
            ['key' => 'is_ppdb_open', 'value' => '0', 'group' => 'ppdb'],
            ['key' => 'ppdb_start_date', 'value' => null, 'group' => 'ppdb'],
            ['key' => 'ppdb_end_date', 'value' => null, 'group' => 'ppdb'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}

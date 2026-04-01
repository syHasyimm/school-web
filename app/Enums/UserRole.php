<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case CalonSiswa = 'calon_siswa';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::CalonSiswa => 'Calon Siswa',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Admin => 'red',
            self::CalonSiswa => 'blue',
        };
    }
}

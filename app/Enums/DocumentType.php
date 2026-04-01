<?php

namespace App\Enums;

enum DocumentType: string
{
    case Kk = 'kk';
    case AktaKelahiran = 'akta_kelahiran';
    case Foto = 'foto';
    case Ijazah = 'ijazah';

    public function label(): string
    {
        return match ($this) {
            self::Kk => 'Kartu Keluarga',
            self::AktaKelahiran => 'Akta Kelahiran',
            self::Foto => 'Pas Foto 3x4',
            self::Ijazah => 'Ijazah/SKL',
        };
    }

    public function isRequired(): bool
    {
        return match ($this) {
            self::Kk, self::AktaKelahiran, self::Foto => true,
            self::Ijazah => false,
        };
    }

    public function maxSizeKb(): int
    {
        return 2048;
    }

    public function allowedExtensions(): array
    {
        return match ($this) {
            self::Foto => ['jpg', 'jpeg', 'png'],
            default => ['jpg', 'jpeg', 'png', 'pdf'],
        };
    }
}

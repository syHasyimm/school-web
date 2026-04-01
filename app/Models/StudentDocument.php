<?php

namespace App\Models;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentDocument extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'file_path',
        'file_size',
        'original_name',
    ];

    protected function casts(): array
    {
        return [
            'type' => DocumentType::class,
            'file_size' => 'integer',
        ];
    }

    // ── Relationships ──

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // ── Accessors ──

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }

        return number_format($bytes / 1024, 0) . ' KB';
    }
}

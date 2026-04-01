<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\StudentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'registration_code',
        'nik',
        'no_kk',
        'nisn',
        'full_name',
        'nickname',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'address',
        'rt',
        'rw',
        'mother_name',
        'father_name',
        'parent_occupation',
        'parent_phone',
        'previous_school',
        'status',
        'rejection_reason',
        'verified_at',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => StudentStatus::class,
            'gender' => Gender::class,
            'birth_date' => 'date',
            'verified_at' => 'datetime',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // ── Scopes ──

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', StudentStatus::Pending);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', StudentStatus::Accepted);
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', StudentStatus::Rejected);
    }

    // ── Helpers ──

    public function isPending(): bool
    {
        return $this->status === StudentStatus::Pending;
    }

    public function isAccepted(): bool
    {
        return $this->status === StudentStatus::Accepted;
    }

    public function isRejected(): bool
    {
        return $this->status === StudentStatus::Rejected;
    }

    public function getFullAddressAttribute(): string
    {
        return "{$this->address}, RT {$this->rt}/RW {$this->rw}";
    }

    public function getBirthInfoAttribute(): string
    {
        return "{$this->birth_place}, {$this->birth_date->translatedFormat('d F Y')}";
    }
}

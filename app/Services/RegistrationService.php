<?php

namespace App\Services;

use App\Enums\StudentStatus;
use App\Models\ActivityLog;
use App\Models\Student;
use App\Models\StudentDocument;
use App\Notifications\PpdbStatusChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function generateRegistrationCode(): string
    {
        $year = now()->year;
        $lastStudent = Student::withTrashed()
            ->where('registration_code', 'like', "PPDB-{$year}-%")
            ->orderByDesc('registration_code')
            ->first();

        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->registration_code, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf("PPDB-%d-%04d", $year, $nextNumber);
    }

    public function createRegistration(array $data, array $documents = []): Student
    {
        return DB::transaction(function () use ($data, $documents) {
            $data['registration_code'] = $this->generateRegistrationCode();
            $data['status'] = StudentStatus::Pending;

            $student = Student::create($data);

            foreach ($documents as $doc) {
                $student->documents()->create($doc);
            }

            ActivityLog::log(
                'ppdb_register',
                "Pendaftaran PPDB baru: {$student->full_name} ({$student->registration_code})",
                $student
            );

            return $student;
        });
    }

    public function updateStatus(Student $student, StudentStatus $status, ?string $rejectionReason = null): void
    {
        DB::transaction(function () use ($student, $status, $rejectionReason) {
            $student->update([
                'status' => $status,
                'rejection_reason' => $status === StudentStatus::Rejected ? $rejectionReason : null,
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);

            ActivityLog::log(
                'ppdb_status_update',
                "Status pendaftaran {$student->full_name} diubah menjadi {$status->label()}",
                $student
            );
        });

        // Send notification outside the transaction so mail failures don't rollback status updates
        try {
            if ($student->user) {
                $student->user->notify(new PpdbStatusChanged($student, $status));
            }
        } catch (\Exception $e) {
            // Log the error but don't prevent the status update
            \Illuminate\Support\Facades\Log::warning('Gagal mengirim notifikasi PPDB: ' . $e->getMessage());
        }
    }

    public function storeDocument(Student $student, $file, string $type): StudentDocument
    {
        $path = $file->store("ppdb/documents/{$student->getKey()}", 'public');

        return $student->documents()->create([
            'type' => $type,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}

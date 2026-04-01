<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Student;

class StudentObserver
{
    public function created(Student $student): void
    {
        ActivityLog::log(
            'student_registered',
            "Pendaftaran baru: {$student->full_name} ({$student->registration_code})",
            $student
        );
    }

    public function updated(Student $student): void
    {
        if ($student->isDirty('status')) {
            ActivityLog::log(
                'student_status_changed',
                "Status {$student->full_name} diubah menjadi {$student->status->label()}",
                $student
            );
        }
    }
}

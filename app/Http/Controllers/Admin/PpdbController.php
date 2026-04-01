<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StudentStatus;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;

class PpdbController extends Controller
{
    public function __construct(protected RegistrationService $registrationService) {}

    public function index(Request $request)
    {
        $students = Student::with('user', 'documents')
            ->when($request->search, function ($q, $s) {
                $q->where(function ($query) use ($s) {
                    $query->where('full_name', 'like', "%{$s}%")
                        ->orWhere('registration_code', 'like', "%{$s}%")
                        ->orWhere('nisn', 'like', "%{$s}%");
                });
            })
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(20);

        $counts = [
            'total' => Student::count(),
            'pending' => Student::pending()->count(),
            'accepted' => Student::accepted()->count(),
            'rejected' => Student::rejected()->count(),
        ];

        return view('admin.ppdb.index', compact('students', 'counts'));
    }

    public function show(Student $student)
    {
        $student->load('user', 'documents', 'verifier');
        return view('admin.ppdb.show', compact('student'));
    }

    public function updateStatus(Request $request, Student $student)
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ], [
            'rejection_reason.required_if' => 'Alasan penolakan wajib diisi.',
        ]);

        $status = StudentStatus::from($validated['status']);

        $this->registrationService->updateStatus(
            $student,
            $status,
            $validated['rejection_reason'] ?? null
        );

        return back()->with('success', "Status pendaftaran berhasil diubah menjadi {$status->label()}.");
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:accepted,rejected',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'rejection_reason' => 'required_if:action,rejected|nullable|string',
        ]);

        $status = StudentStatus::from($validated['action']);
        $students = Student::whereIn('id', $validated['student_ids'])->get();

        foreach ($students as $student) {
            $this->registrationService->updateStatus(
                $student,
                $status,
                $validated['rejection_reason'] ?? null
            );
        }

        return back()->with('success', count($students) . " pendaftar berhasil di-{$status->label()}.");
    }

    public function export(Request $request)
    {
        $status = $request->input('status', 'all');
        $year = now()->year;
        $statusLabel = $status === 'all' ? 'Semua' : StudentStatus::from($status)->label();
        $filename = "Data_Pendaftar_PPDB_{$year}_{$statusLabel}.xlsx";

        return Excel::download(new StudentsExport($status), $filename);
    }
}

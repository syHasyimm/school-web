<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Services\ImageService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request)
    {
        $teachers = Teacher::query()
            ->when($request->search, fn ($q, $s) => $q->where('full_name', 'like', "%{$s}%"))
            ->when($request->status === 'active', fn ($q) => $q->where('is_active', true))
            ->when($request->status === 'inactive', fn ($q) => $q->where('is_active', false))
            ->ordered()
            ->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'nullable|string|max:20|unique:teachers',
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'subject' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $this->imageService->upload($request->file('photo'), 'teachers', 500);
        }

        unset($validated['photo']);
        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'nip' => 'nullable|string|max:20|unique:teachers,nip,' . $teacher->id,
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'subject' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('photo')) {
            $this->imageService->delete($teacher->photo_path);
            $validated['photo_path'] = $this->imageService->upload($request->file('photo'), 'teachers', 500);
        }

        unset($validated['photo']);
        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        $this->imageService->delete($teacher->photo_path);
        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function toggleActive(Teacher $teacher)
    {
        $teacher->update(['is_active' => !$teacher->is_active]);

        $status = $teacher->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Guru {$teacher->full_name} berhasil {$status}.");
    }
}

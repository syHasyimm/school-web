<?php

namespace App\Livewire\Ppdb;

use App\Models\StudentDocument;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReuploadDocuments extends Component
{
    use WithFileUploads;

    public $student;
    public $documents;

    public $kk_file;
    public $akta_file;
    public $photo_file;
    public $ijazah_file;

    public $showModal = false;

    public function mount()
    {
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $this->student = $user->student;
        $this->documents = $this->student ? $this->student->documents->keyBy('type') : collect();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['kk_file', 'akta_file', 'photo_file', 'ijazah_file']);
        $this->resetValidation();
    }

    public function reupload()
    {
        $this->validate([
            'kk_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo_file' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ijazah_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'mimes' => ':attribute harus berformat :values.',
            'max' => 'Ukuran file maksimal 2MB.',
            'image' => ':attribute harus berupa gambar.',
        ], [
            'kk_file' => 'File KK',
            'akta_file' => 'File Akta',
            'photo_file' => 'Pas Foto',
            'ijazah_file' => 'File Ijazah',
        ]);

        // Must upload at least one file
        if (!$this->kk_file && !$this->akta_file && !$this->photo_file && !$this->ijazah_file) {
            $this->addError('kk_file', 'Pilih minimal satu dokumen untuk diunggah ulang.');
            return;
        }

        $uploads = [
            'kk' => $this->kk_file,
            'akta_kelahiran' => $this->akta_file,
            'foto' => $this->photo_file,
            'ijazah' => $this->ijazah_file,
        ];

        foreach ($uploads as $type => $file) {
            if ($file) {
                // Delete old document if exists
                /** @var \App\Models\StudentDocument|null $existing */
                $existing = $this->student->documents()->where('type', $type)->first();
                if ($existing) {
                    Storage::disk('public')->delete($existing->file_path);
                    $existing->delete();
                }

                // Upload new
                $path = $file->store('ppdb/documents/' . $this->student->id, 'public');

                StudentDocument::create([
                    'student_id' => $this->student->id,
                    'type' => $type,
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Reset status to pending for re-review
        $this->student->update([
            'status' => 'pending',
            'rejection_reason' => null,
            'verified_at' => null,
            'verified_by' => null,
        ]);

        $this->closeModal();
        session()->flash('success', 'Dokumen berhasil diunggah ulang. Status pendaftaran Anda telah dikembalikan ke "Dalam Verifikasi".');
        return redirect()->route('ppdb.dashboard');
    }

    public function render()
    {
        return view('livewire.ppdb.reupload-documents');
    }
}

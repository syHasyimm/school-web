<?php

namespace App\Livewire\Ppdb;

use App\Models\Student;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegistrationForm extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $totalSteps = 4;

    // Step 1: Data Diri
    public $nik, $no_kk, $nisn, $full_name, $nickname;
    public $gender = 'L', $birth_place, $birth_date, $religion = 'Islam';
    public $address, $rt, $rw, $previous_school;

    // Step 2: Data Orang Tua
    public $mother_name, $father_name, $parent_occupation, $parent_phone;

    // Step 3: Upload Dokumen
    public $kk_file;
    public $akta_file;
    public $photo_file;
    public $ijazah_file;

    // Step 4: Final Confirmation
    public $is_agreed = false;

    public function mount()
    {
        $this->full_name = auth()->user()->name;
    }

    public function nextStep()
    {
        $this->validateStep();
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function updateStep($step)
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        } elseif ($step == $this->currentStep + 1) {
            $this->nextStep();
        }
    }

    protected function rules()
    {
        return [
            // Step 1
            'nik' => 'required|digits:16|unique:students,nik',
            'no_kk' => 'required|digits:16',
            'nisn' => 'nullable|digits:10|unique:students,nisn',
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:50',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'religion' => 'required|string|max:50',
            'address' => 'required|string',
            'rt' => 'required|digits_between:1,5',
            'rw' => 'required|digits_between:1,5',
            'previous_school' => 'nullable|string|max:255',

            // Step 2
            'mother_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'parent_occupation' => 'nullable|string|max:100',
            'parent_phone' => 'required|string|max:20',

            // Step 3
            'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akta_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo_file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ijazah_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Step 4
            'is_agreed' => 'accepted'
        ];
    }

    protected function messages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'digits' => ':attribute harus :digits digit.',
            'digits_between' => ':attribute harus antara :min hingga :max digit.',
            'max' => ':attribute maksimal :max karakter/KB.',
            'unique' => ':attribute sudah terdaftar dalam sistem.',
            'mimes' => ':attribute harus berformat: :values.',
            'image' => ':attribute harus berupa file gambar.',
            'accepted' => 'Anda harus menyetujui pernyataan kebenaran data.',
            'kk_file.max' => 'Ukuran file KK maksimal 2MB.',
            'akta_file.max' => 'Ukuran file Akta maksimal 2MB.',
            'photo_file.max' => 'Ukuran file Foto maksimal 2MB.',
            'ijazah_file.max' => 'Ukuran file Ijazah maksimal 2MB.',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'nik' => 'NIK',
            'no_kk' => 'Nomor KK',
            'nisn' => 'NISN',
            'full_name' => 'Nama Lengkap',
            'gender' => 'Jenis Kelamin',
            'birth_place' => 'Tempat Lahir',
            'birth_date' => 'Tanggal Lahir',
            'religion' => 'Agama',
            'address' => 'Alamat Rumah',
            'rt' => 'RT',
            'rw' => 'RW',
            'mother_name' => 'Nama Ibu',
            'parent_phone' => 'Nomor WhatsApp',
            'kk_file' => 'File Kartu Keluarga',
            'akta_file' => 'File Akta',
            'photo_file' => 'Pas Foto',
        ];
    }

    private function validateStep()
    {
        // Pastikan nisn menjadi null jika kosong agar rule digits:10 tidak error
        if ($this->nisn === '') {
            $this->nisn = null;
        }

        if ($this->currentStep == 1) {
            $this->validate([
                'nik' => 'required|digits:16|unique:students,nik',
                'no_kk' => 'required|digits:16',
                'nisn' => 'nullable|digits:10|unique:students,nisn',
                'full_name' => 'required|string|max:255',
                'nickname' => 'nullable|string|max:50',
                'gender' => 'required|in:L,P',
                'birth_place' => 'required|string|max:100',
                'birth_date' => 'required|date|before:today',
                'religion' => 'required|string|max:50',
                'address' => 'required|string',
                'rt' => 'required|digits_between:1,5',
                'rw' => 'required|digits_between:1,5',
                'previous_school' => 'nullable|string|max:255',
            ]);
        } elseif ($this->currentStep == 2) {
            $this->validate([
                'mother_name' => 'required|string|max:255',
                'father_name' => 'nullable|string|max:255',
                'parent_occupation' => 'nullable|string|max:100',
                'parent_phone' => 'required|string|max:20',
            ]);
        } elseif ($this->currentStep == 3) {
            $this->validate([
                'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'akta_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'photo_file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'ijazah_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);
        }
    }

    public function submit()
    {
        // Pastikan nisn menjadi null jika kosong sebelum final validation
        if ($this->nisn === '') {
            $this->nisn = null;
        }

        // Final validation
        $this->validate();

        DB::beginTransaction();
        try {
            // Generate Registration Code (PPDB-YYYY-XXXX)
            $year = date('Y');
            $lastStudent = Student::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
            $nextSequence = $lastStudent ? intval(substr($lastStudent->registration_code, -4)) + 1 : 1;
            $registrationCode = 'PPDB-' . $year . '-' . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);

            // Create Student Record
            $student = Student::create([
                'user_id' => auth()->id(),
                'registration_code' => $registrationCode,
                'nik' => $this->nik,
                'no_kk' => $this->no_kk,
                'nisn' => $this->nisn,
                'full_name' => $this->full_name,
                'nickname' => $this->nickname,
                'gender' => $this->gender,
                'birth_place' => $this->birth_place,
                'birth_date' => $this->birth_date,
                'religion' => $this->religion,
                'address' => $this->address,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'mother_name' => $this->mother_name,
                'father_name' => $this->father_name,
                'parent_occupation' => $this->parent_occupation,
                'parent_phone' => $this->parent_phone,
                'previous_school' => $this->previous_school,
                'status' => 'pending',
            ]);

            // Function to handle document upload
            $uploadDocument = function ($file, $type) use ($student) {
                if ($file) {
                    $path = $file->store('ppdb/documents/' . $student->id, 'public');
                    
                    StudentDocument::create([
                        'student_id' => $student->id,
                        'type' => $type,
                        'file_path' => $path,
                        'file_size' => $file->getSize(),
                        'original_name' => $file->getClientOriginalName(),
                    ]);
                }
            };

            // Upload files
            $uploadDocument($this->kk_file, 'kk');
            $uploadDocument($this->akta_file, 'akta_kelahiran');
            $uploadDocument($this->photo_file, 'foto');
            $uploadDocument($this->ijazah_file, 'ijazah');

            DB::commit();

            session()->flash('success', 'Formulir Pendaftaran berhasil dikirim! Silakan mengunduh bukti pendaftaran pada dashboard Anda.');
            return redirect()->route('ppdb.dashboard');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.ppdb.registration-form');
    }
}

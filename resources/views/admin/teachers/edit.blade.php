@extends('layouts.admin')

@section('title', 'Edit Data Guru: ' . $teacher->full_name)

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.teachers.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Ubah Data Guru</h2>
    </div>
</div>

<div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden max-w-4xl">
    <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            
            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-full sm:w-1/3" x-data="imagePreview('{{ $teacher->photo_path ? Storage::url($teacher->photo_path) : '' }}')">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profil (Opsional)</label>
                    <div x-show="!imageUrl" class="flex flex-col items-center justify-center p-6 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-white transition cursor-pointer" @click="$refs.fileInput.click()" style="{{ $teacher->photo_path ? 'display: none;' : '' }}">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span class="text-sm font-medium text-primary-600 text-center">Ganti Foto</span>
                        <p class="text-[10px] text-gray-500 mt-1 text-center">Rasio 3:4 maks 2MB</p>
                    </div>

                    <div x-show="imageUrl" class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm aspect-[3/4] max-w-[200px] mx-auto sm:mx-0 transition-opacity">
                        <img :src="imageUrl" class="w-full h-full object-cover" alt="Preview Image">
                        <button type="button" @click="removeImage" class="absolute top-2 right-2 bg-red-600/90 text-white rounded-md p-1.5 hover:bg-red-700 transition focus:outline-none" title="Batalkan Ganti Foto">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    
                    <input type="file" name="photo" id="photo" class="sr-only" accept="image/jpeg,image/png,image/webp" x-ref="fileInput" @change="fileChosen">
                    
                    <button type="button" x-show="imageUrl && '{{ $teacher->photo_path }}' && imageUrl === '{{ Storage::url($teacher->photo_path) }}'" @click="$refs.fileInput.click()" class="mt-3 w-full sm:max-w-[200px] text-xs font-semibold py-1.5 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition border border-gray-200">
                        Upload Foto Baru
                    </button>
                    
                    @error('photo')
                        <p class="mt-1.5 text-sm text-red-600 font-medium text-center sm:text-left">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex-1 w-full space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $teacher->full_name) }}" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" placeholder="Budi Santoso, S.Pd.">
                            @error('full_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nip" class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip', $teacher->nip) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2 font-mono" placeholder="-">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan jika honorer/bukan ASN.</p>
                            @error('nip')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Nomor Handphone (WhatsApp)</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $teacher->phone) }}"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2 font-mono" placeholder="08...">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="position" class="block text-sm font-semibold text-gray-700 mb-1">Status Kepegawaian / Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" name="position" id="position" value="{{ old('position', $teacher->position) }}" required list="position_options"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" placeholder="Guru Kelas">
                            <datalist id="position_options">
                                <option value="Kepala Sekolah"></option>
                                <option value="Wakil Kepala Sekolah"></option>
                                <option value="Guru Kelas"></option>
                                <option value="Guru Mata Pelajaran"></option>
                                <option value="Tenaga Administrasi"></option>
                                <option value="Operator Sekolah"></option>
                                <option value="Penjaga Sekolah"></option>
                            </datalist>
                            @error('position')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1">Mata Pelajaran yang Diampu</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject', $teacher->subject) }}" list="subject_options"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" placeholder="Pendidikan Agama Islam">
                            <p class="text-xs text-gray-500 mt-1">Isi jika Guru Mata Pelajaran tertentu.</p>
                            <datalist id="subject_options">
                                <option value="Pendidikan Agama Islam"></option>
                                <option value="Pendidikan Jasmani dan Olahraga"></option>
                                <option value="Guru Kelas I"></option>
                                <option value="Guru Kelas II"></option>
                            </datalist>
                            @error('subject')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">Urutan (Sort Order)</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $teacher->order) }}" min="0"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2">
                            <p class="mt-1 text-[11px] text-gray-500">Angka terkecil (0) tampil paling awal. Misal: 1 buat Kepala Sekolah.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status Akun</label>
                            <label class="flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 inline-block transition-colors shrink-0"></div>
                                    <span class="ml-3 text-sm font-semibold text-gray-700 select-none">Aktif (Tampil)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.teachers.index') }}" class="px-5 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 active:bg-primary-800 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Perbarui Profil
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function imagePreview(existingUrl) {
        return {
            imageUrl: existingUrl,
            
            fileChosen(event) {
                if (! event.target.files.length) return
                
                let file = event.target.files[0]
                
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = e => this.imageUrl = e.target.result
            },

            removeImage() {
                this.imageUrl = existingUrl; 
                this.$refs.fileInput.value = '';
            }
        }
    }
</script>
@endpush

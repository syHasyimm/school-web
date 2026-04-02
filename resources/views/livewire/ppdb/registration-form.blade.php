<div>
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <div class="flex flex-col items-center flex-1 relative">
                    <button type="button" 
                        wire:click="updateStep({{ $i }})"
                        @if($i > $currentStep && !($i == 2 && $currentStep == 1)) disabled @endif
                        class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors z-10 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2
                            {{ $currentStep >= $i ? 'bg-primary-600 text-white shadow-md' : 'bg-white border-2 border-gray-200 text-gray-400' }}
                            {{ $i <= $currentStep || ($i == $currentStep + 1) ? 'cursor-pointer hover:bg-primary-700 hover:text-white hover:border-transparent' : 'cursor-not-allowed' }}">
                        @if($currentStep > $i)
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        @else
                            {{ $i }}
                        @endif
                    </button>
                    
                    <span class="text-xs font-semibold mt-2 text-center {{ $currentStep >= $i ? 'text-primary-700' : 'text-gray-400' }}">
                        @switch($i)
                            @case(1) Data Diri @break
                            @case(2) Data O-Tua @break
                            @case(3) Dokumen @break
                            @case(4) Selesai @break
                        @endswitch
                    </span>

                    @if($i < $totalSteps)
                        <div class="absolute top-5 left-1/2 w-full h-1 z-0 {{ $currentStep > $i ? 'bg-primary-500' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Error Summary -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda:</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-10">
            <!-- Step 1: Data Diri Siswa -->
            <div class="{{ $currentStep == 1 ? 'block' : 'hidden' }}">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Identitas Calon Peserta Didik</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NIK Siswa (16 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="nik" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('nik') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: 14060xxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kartu Keluarga <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="no_kk" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('no_kk') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: 14060xxxxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NISN (10 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="nisn" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('nisn') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: 014xxxxxxx">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Asal Sekolah Dasar/TK/PAUD</label>
                        <input type="text" wire:model.blur="previous_school" class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Contoh: TK Cempaka">
                    </div>
                    
                    <div class="md:col-span-2 mt-4"><hr class="border-gray-100"></div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="full_name" class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 bg-gray-50" readonly>
                        <p class="text-xs text-gray-500 mt-1">Sesuai dengan nama akun Anda.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Panggilan</label>
                        <input type="text" wire:model.blur="nickname" class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Contoh: Budi">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select wire:model.blur="gender" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('gender') border-red-300 @else border-gray-300 @enderror">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Agama <span class="text-red-500">*</span></label>
                        <select wire:model.blur="religion" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('religion') border-red-300 @else border-gray-300 @enderror">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="birth_place" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('birth_place') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: Pekanbaru">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" wire:model.blur="birth_date" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('birth_date') border-red-300 @else border-gray-300 @enderror">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Tempat Tinggal (Sesuai KK) <span class="text-red-500">*</span></label>
                        <textarea wire:model.blur="address" rows="3" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('address') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: Jl. Lintas Provinsi, Desa Kepenuhan..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RT <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="rt" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('rt') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: 001">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RW <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="rw" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('rw') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: 002">
                    </div>
                </div>
            </div>

            <!-- Step 2: Data Orang Tua -->
            <div class="{{ $currentStep == 2 ? 'block' : 'hidden' }}">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Informasi Orang Tua / Wali</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ibu Kandung <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="mother_name" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('mother_name') border-red-300 @else border-gray-300 @enderror" placeholder="Sesuai Akta Kelahiran">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Ayah (Opsional)</label>
                        <input type="text" wire:model.blur="father_name" class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Sesuai KK">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pekerjaan Orang Tua / Wali</label>
                        <input type="text" wire:model.blur="parent_occupation" class="w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Contoh: Petani/PNS/Wiraswasta">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor WhatsApp Aktif <span class="text-red-500">*</span></label>
                        <input type="text" wire:model.blur="parent_phone" class="w-full px-4 py-3 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('parent_phone') border-red-300 @else border-gray-300 @enderror" placeholder="Contoh: 081234567890">
                    </div>
                </div>
            </div>

            <!-- Step 3: Pas Foto & Dokumen -->
            <div class="{{ $currentStep == 3 ? 'block' : 'hidden' }}">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Unggah Dokumen Persyaratan</h2>
                
                <div class="space-y-8">
                    <!-- Upload File Component (can be repeated) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Pas Foto -->
                        <div class="card bg-gray-50 p-6 rounded-2xl border border-gray-200">
                            <label class="block text-base font-bold text-gray-900 mb-2">Pas Foto Calon Siswa <span class="text-red-500">*</span></label>
                            <p class="text-sm text-gray-500 mb-4">Latar belakang merah/biru, wajah terlihat jelas. (JPG/PNG maks 2MB).</p>
                            
                            <input type="file" wire:model="photo_file" id="photo_file" class="hidden" accept="image/jpeg,image/png">
                            <label for="photo_file" class="cursor-pointer flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl bg-white hover:bg-primary-50 hover:border-primary-400 transition-colors @error('photo_file') border-red-400 @else border-gray-300 @enderror">
                                @if ($photo_file)
                                    <div class="w-32 h-32 mb-2 rounded shadow-sm overflow-hidden bg-gray-100">
                                        <img src="{{ $photo_file->temporaryUrl() }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-sm font-medium text-emerald-600 truncate max-w-full"><svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Tersimpan</span>
                                @else
                                    <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    <span class="text-sm font-medium text-gray-600">Klik untuk unggah</span>
                                @endif
                            </label>
                            <div wire:loading wire:target="photo_file" class="mt-2 text-sm text-primary-600 font-medium">Mengunggah file...</div>
                        </div>

                        <!-- Kartu Keluarga -->
                        <div class="card bg-gray-50 p-6 rounded-2xl border border-gray-200">
                            <label class="block text-base font-bold text-gray-900 mb-2">Scan/Foto Kartu Keluarga Asli <span class="text-red-500">*</span></label>
                            <p class="text-sm text-gray-500 mb-4">Tulisan harus terbaca dengan jelas. (JPG/PNG/PDF maks 2MB).</p>
                            
                            <input type="file" wire:model="kk_file" id="kk_file" class="hidden" accept=".jpg,.jpeg,.png,.pdf">
                            <label for="kk_file" class="cursor-pointer flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl bg-white hover:bg-primary-50 hover:border-primary-400 transition-colors h-44 @error('kk_file') border-red-400 @else border-gray-300 @enderror">
                                @if ($kk_file)
                                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600 mb-2"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                    <span class="text-sm font-bold text-emerald-600 truncate max-w-full px-2">{{ $kk_file->getClientOriginalName() }}</span>
                                @else
                                    <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span class="text-sm font-medium text-gray-600">Klik untuk unggah</span>
                                @endif
                            </label>
                            <div wire:loading wire:target="kk_file" class="mt-2 text-sm text-primary-600 font-medium">Mengunggah file...</div>
                        </div>

                        <!-- Akta Kelahiran -->
                        <div class="card bg-gray-50 p-6 rounded-2xl border border-gray-200">
                            <label class="block text-base font-bold text-gray-900 mb-2">Scan/Foto Akta Kelahiran Asli <span class="text-red-500">*</span></label>
                            <p class="text-sm text-gray-500 mb-4">Tulisan harus terbaca dengan jelas. (JPG/PNG/PDF maks 2MB).</p>
                            
                            <input type="file" wire:model="akta_file" id="akta_file" class="hidden" accept=".jpg,.jpeg,.png,.pdf">
                            <label for="akta_file" class="cursor-pointer flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl bg-white hover:bg-primary-50 hover:border-primary-400 transition-colors h-44 @error('akta_file') border-red-400 @else border-gray-300 @enderror">
                                @if ($akta_file)
                                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600 mb-2"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                    <span class="text-sm font-bold text-emerald-600 truncate max-w-full px-2">{{ $akta_file->getClientOriginalName() }}</span>
                                @else
                                    <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <span class="text-sm font-medium text-gray-600">Klik untuk unggah</span>
                                @endif
                            </label>
                            <div wire:loading wire:target="akta_file" class="mt-2 text-sm text-primary-600 font-medium">Mengunggah file...</div>
                        </div>

                        <!-- Ijazah / Ket. Lulus -->
                        <div class="card bg-gray-50 p-6 rounded-2xl border border-gray-200">
                            <label class="block text-base font-bold text-gray-900 mb-2">Ijazah / SKL TK/PAUD (Opsional)</label>
                            <p class="text-sm text-gray-500 mb-4">Uraikan riwayat pendidikan jika ada. (JPG/PNG/PDF maks 2MB).</p>
                            
                            <input type="file" wire:model="ijazah_file" id="ijazah_file" class="hidden" accept=".jpg,.jpeg,.png,.pdf">
                            <label for="ijazah_file" class="cursor-pointer flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-xl bg-white hover:bg-primary-50 hover:border-primary-400 transition-colors h-44 @error('ijazah_file') border-red-400 @else border-gray-300 @enderror">
                                @if ($ijazah_file)
                                    <div class="p-3 bg-emerald-50 rounded-full text-emerald-600 mb-2"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                    <span class="text-sm font-bold text-emerald-600 truncate max-w-full px-2">{{ $ijazah_file->getClientOriginalName() }}</span>
                                @else
                                    <svg class="h-10 w-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                    <span class="text-sm font-medium text-gray-600">Klik untuk unggah</span>
                                @endif
                            </label>
                            <div wire:loading wire:target="ijazah_file" class="mt-2 text-sm text-primary-600 font-medium">Mengunggah file...</div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Step 4: Review -->
            <div class="{{ $currentStep == 4 ? 'block' : 'hidden' }}">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Tinjauan Data Pendaftaran</h2>
                
                <div class="bg-primary-50 rounded-xl p-6 mb-8 mt-4 border border-primary-100">
                    <h3 class="font-bold text-primary-800 mb-4 text-lg">Pernyataan Orang Tua / Wali</h3>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_agreed" wire:model="is_agreed" type="checkbox" class="w-5 h-5 text-primary-600 bg-white border-primary-300 rounded focus:ring-primary-600 focus:ring-2">
                        </div>
                        <label for="is_agreed" class="ml-3 text-sm font-medium text-gray-700 leading-relaxed cursor-pointer select-none">
                            Saya yang bertanda tangan sebagai orang tua/wali dari calon peserta didik, dengan ini menyatakan bahwa seluruh data dan dokumen yang saya unggah adalah <strong>BENAR</strong> dan dapat dipertanggungjawabkan secara hukum. Apabila di kemudian hari terbukti ada pemalsuan data, maka saya bersedia menerima sanksi pembatalan kelulusan putra/putri saya.
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm text-gray-600">
                     <div class="space-y-3">
                         <h4 class="font-bold text-gray-900 border-b pb-1 text-base">Identitas Calon Siswa</h4>
                         <div class="flex"><span class="w-32 font-semibold">Nama Lengkap:</span> <span class="font-medium text-gray-900">{{ $full_name ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">NIK:</span> <span>{{ $nik ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">NISN:</span> <span>{{ $nisn ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">TTL:</span> <span>{{ $birth_place ?: '-' }}, {{ $birth_date ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">Jenis Kelamin:</span> <span>{{ $gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span></div>
                     </div>
                     <div class="space-y-3">
                         <h4 class="font-bold text-gray-900 border-b pb-1 text-base">Kontak & Orang Tua</h4>
                         <div class="flex"><span class="w-32 font-semibold">No Keluarga:</span> <span>{{ $no_kk ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">Nama Ibu:</span> <span>{{ $mother_name ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">Nama Ayah:</span> <span>{{ $father_name ?: '-' }}</span></div>
                         <div class="flex"><span class="w-32 font-semibold">No HP/WA:</span> <span>{{ $parent_phone ?: '-' }}</span></div>
                     </div>
                     <div class="md:col-span-2 space-y-3">
                         <h4 class="font-bold text-gray-900 border-b pb-1 text-base">Status Kelengkapan Dokumen</h4>
                         <div class="flex flex-wrap gap-4 mt-2">
                            @if($photo_file)<span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Foto Terunggah</span>@endif
                            @if($kk_file)<span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> KK Terunggah</span>@endif
                            @if($akta_file)<span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Akta Terunggah</span>@endif
                            @if($ijazah_file)<span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold"><svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Ijazah Terunggah</span>@endif
                         </div>
                     </div>
                </div>
            </div>

            <!-- Form Navigation Buttons -->
            <div class="mt-10 flex items-center justify-between border-t border-gray-100 pt-6">
                @if ($currentStep > 1)
                    <button type="button" wire:click="previousStep" class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-bold text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Kembali
                    </button>
                @else
                    <div></div>
                @endif

                @if ($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep" class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-bold rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-md hover:-translate-y-0.5 transition-all">
                        Lanjut ke Langkah Berikutnya
                        <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                @else
                    <button type="button" wire:click="submit" @if(!$is_agreed) disabled @endif class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-md hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Kirim Form Pendaftaran Sekarang
                    </button>
                @endif
            </div>

            <!-- Loading Indicator for Actions -->
            <div wire:loading wire:target="nextStep, previousStep, submit" class="w-full">
                <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm">
                    <div class="bg-white rounded-xl p-6 shadow-2xl flex flex-col items-center">
                        <svg class="animate-spin h-10 w-10 text-primary-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-sm font-bold text-gray-900">Sedang memproses...</p>
                        <p class="text-xs text-gray-500 mt-1">Mohon jangan tutup halaman ini.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

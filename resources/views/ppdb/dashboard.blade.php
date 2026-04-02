@extends('layouts.app')

@section('title', 'Dashboard Calon Siswa - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <div class="bg-gray-50 min-h-screen pt-12 pb-24 border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 block">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Dashboard Calon Siswa</h1>
                <p class="text-gray-600">Selamat datang, {{ auth()->user()->name }}. Kelola pendaftaran PPDB Anda di sini.</p>
            </div>

            <!-- Flash Messages -->
            @if(session('info'))
                <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg shadow-sm flex items-start">
                    <svg class="h-6 w-6 text-blue-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-blue-800 font-medium">{{ session('info') }}</p>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg shadow-sm flex items-start">
                    <svg class="h-6 w-6 text-green-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(!$student)
                <!-- Scenario 1: Belum Mendaftar -->
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-10 border border-gray-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-primary-50 rounded-full opacity-50 blur-3xl z-0"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 mb-6 border-4 border-white shadow-sm">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Anda Belum Mengisi Formulir PPDB</h2>
                        <p class="text-gray-600 mb-8 max-w-lg">Silakan isi formulir registrasi dan lengkapi dokumen yang dibutuhkan untuk melanjutkan proses pendaftaran ke tahap verifikasi.</p>
                        
                        @if(\App\Models\Setting::isPpdbOpen())
                            <a href="{{ route('ppdb.form') }}" class="inline-flex items-center px-8 py-3.5 border border-transparent text-base font-bold rounded-full shadow-lg text-white bg-primary-600 hover:bg-primary-700 hover:shadow-xl hover:-translate-y-1 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Mulai Pendaftaran Sekarang
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        @else
                            <div class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-red-700 bg-red-100 cursor-not-allowed">
                                <svg class="mr-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Pendaftaran Telah Ditutup
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Scenario 2: Sudah Mendaftar -->
                @php
                    $statusVal = is_object($student->status) ? ($student->status->value ?? $student->status) : $student->status;
                @endphp
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column: Status Card & Timeline -->
                    <div class="lg:col-span-1 space-y-8">
                        
                        <!-- Status Badge -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Status Pendaftaran</h3>
                            
                            @if($statusVal === 'pending')
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 text-center">
                                    <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-amber-100 mb-3">
                                        <svg class="w-6 h-6 text-amber-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <p class="text-amber-800 font-bold text-lg mb-1">Dalam Verifikasi</p>
                                    <p class="text-amber-600 text-sm">Berkas Anda sedang diperiksa oleh panitia.</p>
                                </div>
                            @elseif($statusVal === 'accepted')
                                <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
                                    <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <p class="text-green-800 font-bold text-lg mb-1">Diterima</p>
                                    <p class="text-green-600 text-sm">Selamat! Anda telah resmi diterima.</p>
                                </div>
                            @elseif($statusVal === 'rejected')
                                <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-center">
                                    <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-red-100 mb-3">
                                        <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </div>
                                    <p class="text-red-800 font-bold text-lg mb-1">Ditolak</p>
                                    <p class="text-red-600 text-sm">Mohon maaf, pendaftaran Anda ditolak.</p>
                                </div>
                            @endif

                            @if($statusVal === 'rejected' && $student->rejection_reason)
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100 relative">
                                    <span class="absolute -top-3 left-4 bg-white px-2 text-xs font-bold text-gray-500">Alasan Penolakan:</span>
                                    <p class="text-sm text-gray-700 italic mt-1">&quot;{{ $student->rejection_reason }}&quot;</p>
                                </div>
                            @endif

                            {{-- Re-upload Documents (for rejected students) --}}
                            @livewire('ppdb.reupload-documents')
                        </div>

                        <!-- Timeline -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Timeline Proses</h3>
                            
                            <div class="relative pl-8 before:absolute before:inset-y-0 before:left-3 before:w-0.5 before:bg-gray-200 pb-2">
                                <!-- Step 1: Formulir Disubmit -->
                                <div class="relative mb-8">
                                    <span class="absolute -left-9 w-6 h-6 rounded-full bg-primary-100 border-2 border-primary-500 flex items-center justify-center shadow-sm">
                                        <svg class="w-3.5 h-3.5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </span>
                                    <h4 class="text-sm font-bold text-gray-900">Formulir Terkirim</h4>
                                    <p class="text-xs text-gray-500">{{ $student->created_at->translatedFormat('d F Y, H:i') }}</p>
                                </div>

                                <!-- Step 2: Proses Verifikasi -->
                                <div class="relative mb-8">
                                    <span class="absolute -left-9 w-6 h-6 rounded-full {{ $statusVal === 'pending' ? 'bg-amber-100 border-2 border-amber-500' : 'bg-primary-100 border-2 border-primary-500' }} flex items-center justify-center shadow-sm">
                                        @if($statusVal === 'pending')
                                            <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        @endif
                                    </span>
                                    <h4 class="text-sm font-bold {{ $statusVal === 'pending' ? 'text-amber-700' : 'text-gray-900' }}">Verifikasi Berkas</h4>
                                    @if($statusVal === 'pending')
                                        <p class="text-xs text-gray-500">Sedang diperiksa panitia</p>
                                    @else
                                        <p class="text-xs text-gray-500">{{ $student->verified_at ? $student->verified_at->translatedFormat('d F Y, H:i') : 'Selesai' }}</p>
                                    @endif
                                </div>

                                <!-- Step 3: Hasil -->
                                <div class="relative">
                                    <span class="absolute -left-9 w-6 h-6 rounded-full {{ $statusVal === 'pending' ? 'bg-gray-100 border-2 border-gray-300' : ($statusVal === 'accepted' ? 'bg-green-100 border-2 border-green-500' : 'bg-red-100 border-2 border-red-500') }} flex items-center justify-center shadow-sm">
                                        @if($statusVal === 'accepted')
                                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        @elseif($statusVal === 'rejected')
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        @else
                                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                        @endif
                                    </span>
                                    <h4 class="text-sm font-bold {{ $statusVal === 'pending' ? 'text-gray-400' : ($statusVal === 'accepted' ? 'text-green-700' : 'text-red-700') }}">
                                        Pengumuman Hasil
                                    </h4>
                                    @if($statusVal !== 'pending')
                                        <p class="text-xs text-gray-500">{{ $statusVal === 'accepted' ? 'Lulus Verifikasi' : 'Pendaftaran Ditolak' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Registration Data -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            
                            <!-- Header Info & Actions -->
                            <div class="px-8 py-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50/50">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900">Data Pendaftaran</h2>
                                    <p class="text-sm text-gray-500 font-mono mt-1">Kode: <span class="font-bold text-primary-700">{{ $student->registration_code }}</span></p>
                                </div>
                                <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('ppdb.print') }}" target="_blank" class="inline-flex items-center justify-center px-5 py-2.5 border border-primary-200 shadow-sm text-sm font-medium rounded-lg text-primary-700 bg-white hover:bg-primary-50 hover:border-primary-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors w-full sm:w-auto">
                                        <svg class="mr-2 -ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                        Cetak Bukti PDF
                                    </a>
                                </div>
                            </div>

                            <!-- Readonly Data Display -->
                            <div class="p-8">
                                <!-- Data Pribadi -->
                                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Informasi Pribadi Siswa</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 mb-8">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
                                        <p class="font-medium text-gray-900">{{ $student->full_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Panggilan</p>
                                        <p class="font-medium text-gray-900">{{ $student->nickname ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">NIK (Nomor Induk Kependudukan)</p>
                                        <p class="font-medium text-gray-900">{{ $student->nik }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nomor Kartu Keluarga (KK)</p>
                                        <p class="font-medium text-gray-900">{{ $student->no_kk }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">NISN (Jika Ada)</p>
                                        <p class="font-medium text-gray-900">{{ $student->nisn ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Tempat, Tanggal Lahir</p>
                                        <p class="font-medium text-gray-900">{{ $student->birth_place }}, {{ $student->birth_date->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Jenis Kelamin</p>
                                        <p class="font-medium text-gray-900">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Agama</p>
                                        <p class="font-medium text-gray-900">{{ $student->religion }}</p>
                                    </div>
                                </div>

                                <!-- Alamat & Ortu -->
                                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Alamat & Identitas Orang Tua</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 mb-8">
                                    <div class="col-span-full md:col-span-1">
                                        <p class="text-xs text-gray-500 mb-1">Alamat Lengkap (RT/RW)</p>
                                        <p class="font-medium text-gray-900">{{ $student->address }} (RT {{ $student->rt }} / RW {{ $student->rw }})</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Asal Sekolah Sebelumnya</p>
                                        <p class="font-medium text-gray-900">{{ $student->previous_school ?? 'Tidak Ada' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Ibu Kandung</p>
                                        <p class="font-medium text-gray-900">{{ $student->mother_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Ayah Kandung</p>
                                        <p class="font-medium text-gray-900">{{ $student->father_name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Pekerjaan Orang Tua</p>
                                        <p class="font-medium text-gray-900">{{ $student->parent_occupation ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nomor Telepon/HP/WhatsApp</p>
                                        <p class="font-medium text-gray-900">{{ $student->parent_phone }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            @endif

            <!-- Logout Link -->
            <div class="mt-8 text-center flex items-center justify-center space-x-4">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors">Kembali ke Beranda</a>
                <span class="text-gray-300">|</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 transition-colors font-medium">Log Out Akun</button>
                </form>
            </div>

        </div>
    </div>
@endsection

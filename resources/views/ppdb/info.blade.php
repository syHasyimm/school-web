@extends('layouts.app')

@section('title', 'Informasi PPDB - ' . ($ppdbInfo['school_name'] ?? 'SDN 001 Kepenuhan'))

@section('content')
    <div class="bg-gray-50 min-h-screen pt-12 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary-100 text-primary-700 font-bold text-sm tracking-wider uppercase mb-4">Penerimaan Siswa Baru</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Informasi PPDB Tahun Ajaran Baru</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Kami mengundang putra-putri terbaik untuk bergabung dan berkembang bersama di {{ $ppdbInfo['school_name'] ?? 'SDN 001 Kepenuhan' }}.</p>
            </div>

            <!-- Status Banner -->
            @if($isPpdbOpen)
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl shadow-xl p-8 sm:p-10 mb-12 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                    
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center p-3 bg-white/20 rounded-full mb-6 backdrop-blur-sm border border-white/30">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h2 class="text-3xl font-bold mb-3">Pendaftaran PPDB Dibuka!</h2>
                        <p class="text-green-100 text-lg mb-8 max-w-xl mx-auto">Segera daftarkan putra/putri Anda sebelum kuota terpenuhi. Pastikan Anda telah membaca semua persyaratan di bawah ini.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ route('ppdb.dashboard') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-green-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-600 focus:ring-white transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                                    Lanjut ke Dashboard PPDB
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-green-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-600 focus:ring-white transition-all shadow-lg hover:-translate-y-1">
                                    Buat Akun Pendaftaran
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-white/30 text-base font-bold rounded-lg text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-600 focus:ring-white transition-all backdrop-blur-sm">
                                    Sudah Punya Akun? Masuk
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                @php
                    $isPast = $ppdbInfo['ppdb_end_date'] && \Carbon\Carbon::parse($ppdbInfo['ppdb_end_date'])->isPast();
                    $isFuture = $ppdbInfo['ppdb_start_date'] && \Carbon\Carbon::parse($ppdbInfo['ppdb_start_date'])->isFuture();
                @endphp

                @if($isFuture)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 mb-12 text-center" 
                         x-data="{ 
                            targetDate: new Date('{{ \Carbon\Carbon::parse($ppdbInfo['ppdb_start_date'])->toIso8601String() }}').getTime(),
                            days: 0, hours: 0, minutes: 0, seconds: 0,
                            updateTimer() {
                                const now = new Date().getTime();
                                const distance = this.targetDate - now;

                                if (distance < 0) {
                                    window.location.reload();
                                    return;
                                }

                                this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            }
                         }" 
                         x-init="updateTimer(); setInterval(() => updateTimer(), 1000)">
                        
                        <div class="inline-flex items-center justify-center p-4 bg-primary-50 rounded-full mb-6 text-primary-600">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-3">Pendaftaran Segera Dibuka</h2>
                        <p class="text-gray-600 mb-8 max-w-xl mx-auto">Kami sedang mempersiapkan sistem pelayanan terbaik untuk Anda. Pendaftaran akan dibuka dalam waktu:</p>
                        
                        <!-- Alpine JS Countdown -->
                        <div class="flex justify-center gap-4 sm:gap-6">
                            <div class="bg-gray-50 border border-gray-100 w-20 sm:w-24 h-24 sm:h-28 rounded-2xl flex flex-col justify-center items-center shadow-sm">
                                <span class="text-3xl sm:text-4xl font-extrabold text-primary-600 font-mono" x-text="days < 10 ? '0'+days : days">00</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-400 mt-1 uppercase tracking-wider">Hari</span>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 w-20 sm:w-24 h-24 sm:h-28 rounded-2xl flex flex-col justify-center items-center shadow-sm">
                                <span class="text-3xl sm:text-4xl font-extrabold text-primary-600 font-mono" x-text="hours < 10 ? '0'+hours : hours">00</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-400 mt-1 uppercase tracking-wider">Jam</span>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 w-20 sm:w-24 h-24 sm:h-28 rounded-2xl flex flex-col justify-center items-center shadow-sm">
                                <span class="text-3xl sm:text-4xl font-extrabold text-primary-600 font-mono" x-text="minutes < 10 ? '0'+minutes : minutes">00</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-400 mt-1 uppercase tracking-wider">Menit</span>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 w-20 sm:w-24 h-24 sm:h-28 rounded-2xl flex flex-col justify-center items-center shadow-sm">
                                <span class="text-3xl sm:text-4xl font-extrabold text-primary-600 font-mono" x-text="seconds < 10 ? '0'+seconds : seconds">00</span>
                                <span class="text-xs sm:text-sm font-semibold text-gray-400 mt-1 uppercase tracking-wider">Detik</span>
                            </div>
                        </div>

                        <div class="mt-8">
                            <p class="text-sm font-medium text-gray-500 bg-gray-100 py-2 px-6 rounded-full inline-block">
                                Dibuka pada: {{ \Carbon\Carbon::parse($ppdbInfo['ppdb_start_date'])->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-8 sm:p-10 mb-12 text-center">
                        <div class="inline-flex items-center justify-center p-3 bg-red-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-red-800 mb-2">Pendaftaran Telah Ditutup</h2>
                        <p class="text-red-600 mb-0">Mohon maaf, periode Penerimaan Peserta Didik Baru tahun ini telah berakhir (sejak {{ $ppdbInfo['ppdb_end_date'] ? \Carbon\Carbon::parse($ppdbInfo['ppdb_end_date'])->translatedFormat('d F Y') : '-' }}).</p>
                    </div>
                @endif
            @endif

            <!-- Info Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Syarat Pendaftaran -->
                    <div class="p-8 md:p-12 border-b md:border-b-0 md:border-r border-gray-100">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Syarat Berkas Fisik</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span class="text-gray-600">Scan/Foto Asli Kartu Keluarga (KK)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span class="text-gray-600">Scan/Foto Asli Akta Kelahiran</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span class="text-gray-600">Pas Foto Berwarna terbaru (ukuran 3x4)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span class="text-gray-500 italic">Ijazah/Surat Keterangan Lulus dari asal sekolah PAUD/TK (Opsional)</span>
                            </li>
                        </ul>
                        <p class="text-sm text-amber-600 bg-amber-50 p-3 rounded-lg mt-6 border border-amber-200">
                            <strong>Perhatian:</strong> Ukuran total setiap file upload maksimal 2MB dengan format JPG, PNG, atau PDF.
                        </p>
                    </div>

                    <!-- Alur Pendaftaran -->
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-secondary-50 text-secondary-600 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Alur Pendaftaran</h3>
                        </div>

                        <div class="relative pl-6 sm:pl-8 before:absolute before:inset-y-0 before:left-2.5 sm:before:left-3.5 before:w-px before:bg-gray-200 space-y-8">
                            <div class="relative">
                                <span class="absolute -left-[33px] sm:-left-[39px] w-6 h-6 rounded-full bg-white border-2 border-primary-500 font-bold text-xs text-primary-600 flex items-center justify-center">1</span>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Buat Akun</h4>
                                <p class="text-gray-600 text-sm">Orang tua/wali membuat akun baru menggunakan alamat email aktif.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] sm:-left-[39px] w-6 h-6 rounded-full bg-white border-2 border-primary-500 font-bold text-xs text-primary-600 flex items-center justify-center">2</span>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Isi Formulir Online</h4>
                                <p class="text-gray-600 text-sm">Login dan lengkapi formulir Multi-Step serta unggah dokumen yang dipersyaratkan.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] sm:-left-[39px] w-6 h-6 rounded-full bg-white border-2 border-primary-500 font-bold text-xs text-primary-600 flex items-center justify-center">3</span>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Verifikasi Admin</h4>
                                <p class="text-gray-600 text-sm">Tim kami akan memverifikasi kesesuaian data dengan dokumen pendukung.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] sm:-left-[39px] w-6 h-6 rounded-full bg-white border-2 border-primary-500 font-bold text-xs text-primary-600 flex items-center justify-center">4</span>
                                <h4 class="text-lg font-bold text-gray-900 mb-1">Cetak & Bawa Bukti FISIK</h4>
                                <p class="text-gray-600 text-sm">Setelah diverifikasi, cetak Bukti Pendaftaran PDF dan bawa berkas fisiknya ke sekolah.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

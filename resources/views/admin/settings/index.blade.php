@extends('layouts.admin')

@section('title', 'Konfigurasi Sistem')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-900 leading-tight">Pengaturan Website & PPDB</h2>
    <p class="text-sm text-gray-500 mt-1">Kelola informasi inti sekolah, detail kontak, dan preferensi portal pendaftaran.</p>
</div>

<!-- Tabs Component with Alpine.js -->
<div x-data="{ activeTab: 'general' }" class="bg-transparent">
    
    <!-- Tab Navigation -->
    <div class="mb-6 overflow-x-auto custom-scrollbar pb-2">
        <nav class="flex space-x-2 border-b border-gray-200 min-w-max" aria-label="Tabs">
            <button @click="activeTab = 'general'" 
                :class="activeTab === 'general' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition focus:outline-none flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                Identitas Sekolah
            </button>
            <button @click="activeTab = 'about'" 
                :class="activeTab === 'about' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition focus:outline-none flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Profil Web (Tentang)
            </button>
            <button @click="activeTab = 'ppdb'" 
                :class="activeTab === 'ppdb' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition focus:outline-none flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                Sistem Pendaftaran
            </button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="mt-4">
        
        <!-- Tab 1: General Settings -->
        <div x-show="activeTab === 'general'" x-transition.opacity.duration.300ms style="display: none;" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.settings.update-general') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Informasi Umum Kampus</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama / Entitas Sekolah</label>
                            <input type="text" name="school_name" value="{{ old('school_name', App\Models\Setting::get('school_name')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon Sekolah</label>
                            <input type="text" name="phone" value="{{ old('phone', App\Models\Setting::get('phone')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email Resmi</label>
                            <input type="email" name="email" value="{{ old('email', App\Models\Setting::get('email')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Fisik Lengkap</label>
                            <textarea name="address" rows="2" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" required>{{ old('address', App\Models\Setting::get('address')) }}</textarea>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Embed Google Maps (Opsional)</label>
                            <textarea name="google_maps_embed" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm font-mono text-xs focus:border-primary-500 focus:ring-primary-500 px-4 py-2 text-gray-600">{{ old('google_maps_embed', App\Models\Setting::get('google_maps_embed')) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Paste iframe Google Maps di sini (contoh: <code>&lt;iframe src="https://www.google.com/maps/embed..."&gt;&lt;/iframe&gt;</code>)</p>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-100 pt-5 mt-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Resmi (Header Website)</label>
                            
                            <div class="flex items-start gap-6">
                                <div class="w-32 h-32 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center shrink-0 p-2 relative group overflow-hidden">
                                    @if(App\Models\Setting::get('logo_path'))
                                        <img src="{{ asset('storage/' . App\Models\Setting::get('logo_path')) }}" alt="Logo saat ini" class="w-full h-full object-contain">
                                        <div class="absolute inset-0 bg-black/40 xl:opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-[10px] font-bold tracking-wider">GANTI</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 font-bold block pb-1">3:4</span>
                                    @endif
                                </div>
                                <div class="flex-1 w-full">
                                    <input type="file" name="logo" id="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition" accept="image/png,image/jpeg,image/webp">
                                    <p class="mt-2 text-xs text-gray-500 leading-relaxed">Pilih PNG transparan untuk hasil terbaik. Resolusi direkomendasikan 500x500px, maksimal 2MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end rounded-b-2xl border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">Simpan Identitas</button>
                </div>
            </form>
        </div>

        <!-- Tab 2: About / Profil Sekolah -->
        <div x-show="activeTab === 'about'" x-transition.opacity.duration.300ms style="display: none;" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.settings.update-about') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Profil Sambutan & Visi Misi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Kepsek Section -->
                        <div class="md:col-span-2 bg-indigo-50/50 p-6 rounded-xl border border-indigo-100">
                            <h4 class="font-bold text-indigo-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                Pimpinan Sekolah
                            </h4>
                            <div class="flex flex-col sm:flex-row gap-6">
                                <div class="w-32 h-40 bg-white rounded-lg border border-indigo-200 flex items-center justify-center shrink-0 p-1 relative overflow-hidden shadow-sm">
                                    @if(App\Models\Setting::get('principal_photo'))
                                        <img src="{{ asset('storage/' . App\Models\Setting::get('principal_photo')) }}" alt="Foto Kepsek" class="w-full h-full object-cover rounded-md">
                                    @else
                                        <span class="text-indigo-300 font-bold block">FOTO</span>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-4 w-full">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap Kepala Sekolah</label>
                                        <input type="text" name="principal_name" value="{{ old('principal_name', App\Models\Setting::get('principal_name')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Foto Baru (Opsional)</label>
                                        <input type="file" name="principal_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 transition" accept="image/png,image/jpeg,image/webp">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-6 pt-2">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Visi Misi Sekolah</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1 font-medium">Deklarasi Visi:</p>
                                        <textarea name="vision" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-3" placeholder="Menjadi sekolah yang berakhlak mulia..." required>{{ old('vision', App\Models\Setting::get('vision')) }}</textarea>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1 font-medium">Objektif Misi (Gisakan format angka 1. 2. 3..):</p>
                                        <textarea name="mission" rows="4" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-3" placeholder="1. Menyelenggarakan...&#10;2. Mendidik..." required>{{ old('mission', App\Models\Setting::get('mission')) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Sejarah Singkat / Narasi Profil</label>
                                <textarea name="history" rows="6" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-3" placeholder="SDN 001 Kepenuhan berdiri sejak tahun..." required>{{ old('history', App\Models\Setting::get('history')) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Akan terbit sebagai teks sambutan di halaman utama / profil khusus.</p>
                            </div>

                            <div class="border-t border-gray-100 pt-5 mt-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto / Gambar Sejarah</label>
                                <div class="flex items-start gap-6">
                                    <div class="w-32 h-24 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center shrink-0 p-2 relative group overflow-hidden">
                                        @if(App\Models\Setting::get('history_photo'))
                                            <img src="{{ asset('storage/' . App\Models\Setting::get('history_photo')) }}" alt="Foto Sejarah" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/40 xl:opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="text-white text-[10px] font-bold tracking-wider">GANTI</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 font-bold block pb-1 border-b border-gray-300">GAMBAR</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" name="history_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition" accept="image/png,image/jpeg,image/webp">
                                        <p class="mt-2 text-xs text-gray-500 leading-relaxed">Pilih foto/gambar ilustrasi sejarah sekolah. Resolusi direkomendasikan rasio 16:9 (contoh: 800x450px).</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-5 mt-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Bagan Struktur Organisasi</label>
                                <div class="flex items-start gap-6">
                                    <div class="w-32 h-32 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center shrink-0 p-2 relative group overflow-hidden">
                                        @if(App\Models\Setting::get('org_structure'))
                                            <img src="{{ asset('storage/' . App\Models\Setting::get('org_structure')) }}" alt="Struktur" class="w-full h-full object-contain">
                                            <div class="absolute inset-0 bg-black/40 xl:opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="text-white text-[10px] font-bold tracking-wider">GANTI</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 font-bold block pb-1 border-b border-gray-300">BAGAN</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 w-full">
                                        <input type="file" name="org_structure" id="org_structure" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition" accept="image/png,image/jpeg,image/webp">
                                        <p class="mt-2 text-xs text-gray-500 leading-relaxed">Unggah file struktur organisasi sekolah. Direkomendasikan format lanskap (lebar memanjang) dengan latar belakang transparan/putih.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end rounded-b-2xl border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">Update Profil</button>
                </div>
            </form>
        </div>

        <!-- Tab 3: PPDB Settings -->
        <div x-show="activeTab === 'ppdb'" x-transition.opacity.duration.300ms style="display: none;" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
            <form action="{{ route('admin.settings.update-ppdb') }}" method="POST">
                @csrf @method('PUT')
                <div class="p-6 sm:p-8 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Konfigurasi Panel Register PPDB</h3>
                    
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-6">
                        <label class="block text-sm font-bold text-blue-900 mb-4">Gatekeeper Sistem Penerimaan</label>
                        <label class="flex items-center cursor-pointer max-w-max p-3 bg-white rounded-lg shadow-sm border border-blue-100 hover:border-blue-300 transition">
                            <input type="hidden" name="is_ppdb_open" value="0">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_ppdb_open" value="1" class="sr-only peer" {{ old('is_ppdb_open', App\Models\Setting::get('is_ppdb_open')) == '1' ? 'checked' : '' }}>
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-500 inline-block transition-colors shrink-0 object-right"></div>
                                <span class="ml-4 text-sm font-bold text-gray-800 tracking-wide select-none">BUKA PORTAL PPDB</span>
                            </div>
                        </label>
                        <p class="text-xs text-blue-700 mt-3 leading-relaxed">Jika dimatikan, halaman pendaftaran murid baru tidak bisa diakses sepenuhnya tanpa memandang jadwal waktu di bawah ini.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Mulai Pendaftaran (Opsional)</label>
                            <input type="datetime-local" name="ppdb_start_date" value="{{ old('ppdb_start_date', App\Models\Setting::get('ppdb_start_date')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2">
                            <p class="mt-1 text-xs text-gray-500">Sistem otomatis dibuka pada jadwal ini (Jika portal di atas ON).</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Batas Akhir (Deadline)</label>
                            <input type="datetime-local" name="ppdb_end_date" value="{{ old('ppdb_end_date', App\Models\Setting::get('ppdb_end_date')) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2">
                            <p class="mt-1 text-xs text-gray-500">Form otomatis tertutup melewati waktu ini. Digunakan juga untuk penghitungan mundur (Countdown).</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end rounded-b-2xl border-t border-gray-200">
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition">Terapkan Jadwal</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

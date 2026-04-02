@extends('layouts.app')

@section('title', 'Tentang Kami - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Header Banner -->
    <div class="bg-primary-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,var(--tw-gradient-stops))] from-white via-primary-900 to-black"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Profil Lengkap Sekolah</h1>
                <p class="text-xl text-primary-200 max-w-2xl mx-auto">Mengenal lebih dekat {{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}.</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div x-data="{ activeTab: 'sejarah' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Tabs Navigation -->
                <div class="flex flex-col sm:flex-row border-b border-gray-200 overflow-x-auto hide-scroll">
                    <button @click="activeTab = 'sejarah'" :class="{'border-primary-500 text-primary-600 bg-primary-50/50': activeTab === 'sejarah', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'sejarah'}" class="whitespace-nowrap py-5 px-8 border-b-2 font-semibold text-lg transition-colors flex-1 text-center">
                        Sejarah Panjang
                    </button>
                    <button @click="activeTab = 'visi_misi'" :class="{'border-primary-500 text-primary-600 bg-primary-50/50': activeTab === 'visi_misi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'visi_misi'}" class="whitespace-nowrap py-5 px-8 border-b-2 font-semibold text-lg transition-colors flex-1 text-center">
                        Visi & Misi
                    </button>
                    <button @click="activeTab = 'struktur'" :class="{'border-primary-500 text-primary-600 bg-primary-50/50': activeTab === 'struktur', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'struktur'}" class="whitespace-nowrap py-5 px-8 border-b-2 font-semibold text-lg transition-colors flex-1 text-center">
                        Struktur Organisasi
                    </button>
                    <button @click="activeTab = 'profil'" :class="{'border-primary-500 text-primary-600 bg-primary-50/50': activeTab === 'profil', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'profil'}" class="whitespace-nowrap py-5 px-8 border-b-2 font-semibold text-lg transition-colors flex-1 text-center">
                        Profil Kepala Sekolah
                    </button>
                </div>

                <!-- Tabs Content -->
                <div class="p-8 md:p-12">
                    
                    <!-- Tab: Sejarah -->
                    <div x-show="activeTab === 'sejarah'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <x-section-title title="Sejarah Berdirinya Sekolah" />
                        
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mt-8">
                            <!-- Narasi Sejarah -->
                            <div class="lg:col-span-5 prose prose-lg text-gray-600 max-w-none prose-headings:text-gray-900 prose-a:text-primary-600">
                                <div class="bg-primary-50/50 p-6 rounded-2xl border border-primary-100 shadow-sm mb-6">
                                    <h3 class="text-2xl font-bold text-primary-800 mb-4 mt-0 flex items-center gap-2">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        Jejak Langkah Kami
                                    </h3>
                                    {!! \App\Models\Setting::get('history', '<p>Sejarah sekolah belum ditambahkan secara rinci oleh administrator.</p>') !!}
                                </div>
                                @if(App\Models\Setting::get('history_photo'))
                                    <img src="{{ Storage::url(App\Models\Setting::get('history_photo')) }}" alt="Sejarah Sekolah" class="rounded-2xl shadow-md w-full object-cover h-64 hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="rounded-2xl shadow-md w-full h-64 bg-primary-100/50 flex flex-col items-center justify-center text-primary-400 border border-primary-100">
                                        <svg class="w-16 h-16 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium opacity-50">Foto Sejarah Belum Tersedia</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Timeline -->
                            <div class="lg:col-span-7">
                                <div class="relative border-l-4 border-primary-200 ml-4 md:ml-8 space-y-10 py-2">
                                    <!-- Timeline Item 1 -->
                                    <div class="relative pl-8 md:pl-10 group">
                                        <div class="absolute -left-[14px] top-1 bg-white h-6 w-6 rounded-full border-4 border-primary-300 group-hover:border-primary-500 transition-colors shadow-sm"></div>
                                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                                            <span class="inline-block py-1 px-4 rounded-full bg-primary-100 text-primary-700 text-sm font-bold mb-3 shadow-sm">Tahun 1980</span>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Awal Mula Berdiri</h3>
                                            <p class="text-gray-600 leading-relaxed">SDN 001 Kepenuhan resmi didirikan untuk memenuhi kebutuhan pendidikan dasar di wilayah Kepenuhan, menjadi salah satu tonggak awal pendidikan masyarakat di daerah ini.</p>
                                        </div>
                                    </div>

                                    <!-- Timeline Item 2 -->
                                    <div class="relative pl-8 md:pl-10 group">
                                        <div class="absolute -left-[14px] top-1 bg-white h-6 w-6 rounded-full border-4 border-primary-300 group-hover:border-primary-500 transition-colors shadow-sm"></div>
                                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                                            <span class="inline-block py-1 px-4 rounded-full bg-primary-100 text-primary-700 text-sm font-bold mb-3 shadow-sm">Tahun 1995</span>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Pengembangan Fasilitas</h3>
                                            <p class="text-gray-600 leading-relaxed">Melakukan renovasi besar-besaran dan penambahan ruang kelas baru untuk mengakomodasi peningkatan jumlah peserta didik yang signifikan.</p>
                                        </div>
                                    </div>

                                    <!-- Timeline Item 3 -->
                                    <div class="relative pl-8 md:pl-10 group">
                                        <div class="absolute -left-[14px] top-1 bg-white h-6 w-6 rounded-full border-4 border-primary-300 group-hover:border-primary-500 transition-colors shadow-sm"></div>
                                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group-hover:-translate-y-1">
                                            <span class="inline-block py-1 px-4 rounded-full bg-primary-100 text-primary-700 text-sm font-bold mb-3 shadow-sm">Tahun 2015</span>
                                            <h3 class="text-xl font-bold text-gray-900 mb-2">Akreditasi & Prestasi</h3>
                                            <p class="text-gray-600 leading-relaxed">Berhasil meraih akreditasi A dan memenangkan berbagai perlombaan tingkat kabupaten/kota di bidang akademik maupun ekstrakurikuler.</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Timeline Item 4 (Masa Kini) -->
                                    <div class="relative pl-8 md:pl-10 group">
                                        <!-- Animated Pulse Dot -->
                                        <div class="absolute -left-[14px] top-1 bg-secondary-500 h-6 w-6 rounded-full border-4 border-white shadow-md animate-pulse"></div>
                                        
                                        <div class="bg-gradient-to-br from-primary-600 to-primary-800 p-6 rounded-2xl text-white shadow-lg relative overflow-hidden transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-xl">
                                            <!-- Decorative bg shape -->
                                            <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -mr-16 -mt-16 opacity-10"></div>
                                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full -ml-12 -mb-12 opacity-10"></div>
                                            
                                            <span class="inline-block py-1 px-4 rounded-full bg-white/20 text-white text-sm font-bold mb-3 backdrop-blur-sm border border-white/30">Masa Kini</span>
                                            <h3 class="text-xl font-bold text-white mb-2 relative z-10">Digitalisasi & Inovasi</h3>
                                            <p class="text-primary-100 leading-relaxed relative z-10">Menerapkan pembelajaran berbasis teknologi dan transformasi menjadi sekolah yang berfokus pada pengembangan profil Pelajar Pancasila.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Visi Misi -->
                    <div x-show="activeTab === 'visi_misi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            <div>
                                <div class="bg-primary-50 p-8 rounded-2xl h-full border border-primary-100">
                                    <div class="flex items-center gap-4 mb-6 text-primary-600">
                                        <div class="p-3 bg-white rounded-xl shadow-sm"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></div>
                                        <h2 class="text-3xl font-bold">Visi Kami</h2>
                                    </div>
                                    <div class="prose prose-lg text-gray-700">
                                        {!! \App\Models\Setting::get('vision', '<p>Visi belum ditambahkan.</p>') !!}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="bg-secondary-50 p-8 rounded-2xl h-full border border-secondary-100">
                                    <div class="flex items-center gap-4 mb-6 text-secondary-600">
                                        <div class="p-3 bg-white rounded-xl shadow-sm"><svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>
                                        <h2 class="text-3xl font-bold">Misi Kami</h2>
                                    </div>
                                    <div class="prose prose-lg text-gray-700">
                                        @php
                                            $missionText = \App\Models\Setting::get('mission', 'Misi belum ditambahkan.');
                                            $missionItems = array_filter(array_map('trim', explode("\n", $missionText)));
                                        @endphp
                                        @if(count($missionItems) > 0)
                                            <ol class="list-decimal pl-5 space-y-2 marker:font-bold marker:text-secondary-600">
                                                @foreach($missionItems as $item)
                                                    <li>{{ preg_replace('/^(\d+\.|-|[*])\s*/', '', $item) }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p>Misi belum ditambahkan.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Struktur Organisasi -->
                    <div x-show="activeTab === 'struktur'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <x-section-title title="Struktur Organisasi Sekolah" />
                        <div class="text-center bg-gray-50 rounded-2xl p-6 sm:p-12 border border-gray-100">
                            @if(\App\Models\Setting::get('org_structure'))
                                <img src="{{ asset('storage/' . \App\Models\Setting::get('org_structure')) }}" alt="Bagan Struktur Organisasi {{ \App\Models\Setting::get('school_name', 'Sekolah') }}" class="w-full max-w-5xl mx-auto rounded-xl shadow-md border border-gray-200">
                            @else
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <p class="text-xl font-medium text-gray-600 mb-2">Bagan Struktur Organisasi</p>
                                <p class="text-gray-500">Bagan belum diunggah oleh administrator.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Profil -->
                    <div x-show="activeTab === 'profil'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="flex flex-col md:flex-row gap-12 items-center md:items-start">
                            <div class="w-48 h-48 md:w-64 md:h-64 shrink-0">
                                @if(\App\Models\Setting::get('principal_photo'))
                                    <img src="{{ asset('storage/' . \App\Models\Setting::get('principal_photo')) }}" alt="Kepala Sekolah" class="w-full h-full object-cover rounded-3xl shadow-xl shadow-gray-200 block border-4 border-white">
                                @else
                                    <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Kepala Sekolah" class="w-full h-full object-cover rounded-3xl shadow-xl shadow-gray-200 block border-4 border-white grayscale">
                                @endif
                            </div>
                            <div>
                                <x-section-title title="Sambutan Kepala Sekolah" />
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ \App\Models\Setting::get('principal_name', 'Nama Kepala Sekolah') }}</h3>
                                <p class="text-primary-600 font-medium mb-6">Kepala Sekolah {{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}</p>
                                
                                <div class="prose prose-lg text-gray-600">
                                    <p>Pendidikan dasar adalah pondasi awal untuk mencerdaskan kehidupan bangsa. Kami berusaha sekuat tenaga untuk menghadirkan iklim pembelajaran yang menyenangkan, interaktif, dan penuh dengan nilai-nilai karakter luhur.</p>
                                    <p>Kami mengajak seluruh orangtua wali murid dan stakeholder pendidikan setempat untuk bahu-membahu mengembangkan potensi anak-anak kita. Semua anak adalah bintang, dan kitalah arsitek masa depannya.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

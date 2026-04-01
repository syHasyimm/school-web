@extends('layouts.app')

@section('title', \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-gray-900 h-[600px] flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="School presentation" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-linear-to-t from-gray-900 pb-32"></div>
        </div>

        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-medium mb-6">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                Pendidikan Dasar Berkualitas
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight mb-6">
                Selamat Datang di <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-linear-to-r from-primary-400 to-primary-200">
                    {{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}
                </span>
            </h1>
            <p class="mt-4 text-xl sm:text-2xl text-gray-300 max-w-3xl mx-auto mb-10 font-light leading-relaxed">
                Membentuk generasi cerdas, berkarakter, dan inovatif untuk masa depan yang gemilang.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(App\Models\Setting::isPpdbOpen())
                    <a href="{{ route('ppdb.info') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-white bg-primary-600 hover:bg-primary-700 shadow-lg hover:shadow-primary-600/30 transition-all hover:-translate-y-1">
                        Daftarkan Anak
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                @endif
                <a href="{{ route('about') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-white/30 text-base font-bold rounded-lg text-white hover:bg-white/10 backdrop-blur-sm transition-all">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

        <!-- Wave decorative bottom -->
        <div class="absolute bottom-0 inset-x-0">
            <svg class="w-full h-16 md:h-24 fill-gray-50 -mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill-opacity="1" d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,218.7C672,235,768,245,864,229.3C960,213,1056,171,1152,165.3C1248,160,1344,192,1392,208L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Stats & Info -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-10 sm:-mt-16 z-20 pb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 border border-gray-100 flex items-start gap-5 hover:-translate-y-1 transition-transform">
                <div class="bg-primary-50 p-4 rounded-xl text-primary-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $teacherCount }}+</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Tenaga Pendidik Profesional</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 border border-gray-100 flex items-start gap-5 hover:-translate-y-1 transition-transform">
                <div class="bg-secondary-50 p-4 rounded-xl text-secondary-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $studentCount }}+</h3>
                    <p class="text-gray-600 leading-relaxed font-medium">Siswa Terdaftar & Aktif</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 border border-gray-100 flex items-start gap-5 hover:-translate-y-1 transition-transform">
                <div class="bg-green-50 p-4 rounded-xl text-green-600">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Kurikulum Merdeka</h3>
                    <p class="text-gray-600 leading-relaxed">Pembelajaran berfokus pada siswa dan pengembangan karakter.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sambutan Kepala Sekolah -->
    <div class="py-16 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                    <div class="lg:col-span-5 mb-10 lg:mb-0 relative">
                        <div class="absolute -top-4 -left-4 w-72 h-72 bg-primary-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob"></div>
                        <div class="absolute -bottom-8 -right-4 w-72 h-72 bg-secondary-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-blob animation-delay-2000"></div>
                        <div class="relative">
                            @if(\App\Models\Setting::get('principal_photo'))
                                <img class="w-full h-auto rounded-3xl object-cover shadow-2xl z-10 relative" src="{{ asset('storage/' . \App\Models\Setting::get('principal_photo')) }}" alt="Kepala Sekolah">
                            @else
                                <img class="w-full h-auto rounded-3xl object-cover shadow-2xl z-10 relative grayscale hover:grayscale-0 transition-all duration-700" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Sambutan Kepala Sekolah">
                            @endif
                            <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl p-6 shadow-xl border border-gray-100 z-20">
                                <p class="text-primary-600 font-bold text-2xl mb-1">20+</p>
                                <p class="text-gray-500 text-sm font-medium">Tahun Mengabdi</p>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-7">
                        <x-section-title title="Sambutan Kepala Sekolah" />
                        <div class="prose prose-lg text-gray-600">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ \App\Models\Setting::get('principal_name', 'Nama Kepala Sekolah') }}</h3>
                            <div class="relative pl-6 before:absolute before:inset-y-0 before:left-0 before:w-1 before:bg-primary-500 before:rounded-full">
                                <p class="italic mb-6 text-xl">"Pendidikan adalah paspor ke masa depan, karena hari esok adalah milik mereka yang mempersiapkannya hari ini."</p>
                                <p>Selamat datang di website resmi {{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}. Kami sangat senang dan bangga dapat menghadirkan informasi seputar sekolah kami secara online.</p>
                                <p>Website ini merupakan salah satu sarana komunikasi antara sekolah, siswa, orang tua murid, dan masyarakat luas agar dapat dengan mudah mendapatkan berbagai informasi tentang kegiatan, program sekolah, dan penerimaan peserta didik baru (PPDB).</p>
                            </div>
                            <div class="mt-8">
                                <a href="{{ route('about') }}" class="text-primary-600 font-semibold hover:text-primary-800 flex items-center group">
                                    Profil Lengkap Sekolah
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Posts -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <x-section-title title="Berita & Informasi Terbaru" subtitle="Ikuti perkembangan, kegiatan, dan pengumuman terbaru di sekolah kami." />
                <a href="{{ route('posts.index') }}" class="hidden md:inline-flex items-center text-primary-600 font-medium hover:text-primary-800 mb-5">
                    Lihat Semua Berita
                    <svg class="ml-1 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                    <x-card class="flex flex-col h-full group">
                        <a href="{{ route('posts.show', $post->slug) }}" class="relative block h-56 overflow-hidden">
                            @if($post->image_path)
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400&q=80" alt="Placeholder" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 filter brightness-90">
                            @endif
                            <div class="absolute inset-0 bg-linear-to-t from-gray-900/60 to-transparent"></div>
                            @if($post->categories->first())
                                <span class="absolute top-4 left-4 bg-primary-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                    {{ $post->categories->first()->name }}
                                </span>
                            @endif
                        </a>
                        <div class="p-6 flex flex-col grow">
                            <div class="flex items-center text-sm text-gray-500 mb-3 space-x-4">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $post->published_at->translatedFormat('d F Y') }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    {{ $post->views_count }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-600 mb-4 line-clamp-3 text-sm leading-relaxed">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-sm mr-3">
                                        {{ substr($post->author->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $post->author->name ?? 'Admin' }}</span>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('posts.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Semua Berita
                </a>
            </div>
        </div>
    </div>

    <!-- PPDB Call to Action Section -->
    <div class="py-24 bg-white relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-[2.5rem] p-10 md:p-16 text-center border border-gray-100 shadow-sm relative overflow-hidden">
                <!-- Soft elegant accents -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-primary-200/30 rounded-full opacity-50 blur-3xl mix-blend-multiply"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-secondary-200/30 rounded-full opacity-50 blur-3xl mix-blend-multiply"></div>

                <div class="relative z-10">
                    <span class="inline-block py-1 px-3 rounded-full bg-primary-50 text-primary-600 font-semibold tracking-wider uppercase text-xs mb-6 border border-primary-100">Penerimaan Siswa Baru</span>
                    <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight">
                        Mari Bergabung Bersama Kami
                    </h2>
                    <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600 mb-10 leading-relaxed font-light">
                        Pendaftaran Peserta Didik Baru (PPDB) Tahun Ajaran Ini telah dibuka. Jadilah bagian dari generasi cerdas dan berkarakter di <span class="font-semibold text-gray-800">{{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}</span>.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        @if(App\Models\Setting::isPpdbOpen())
                            <a href="{{ route('ppdb.info') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-white bg-primary-600 hover:bg-primary-700 shadow-lg hover:shadow-primary-600/30 transition-all duration-300 hover:-translate-y-1">
                                Daftarkan Anak
                                <svg class="ml-2 w-5 h-5 -mr-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </a>
                        @else
                            <a href="{{ route('ppdb.info') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-lg text-primary-700 bg-primary-50 hover:bg-primary-100 transition-all duration-300 hover:-translate-y-1">
                                Informasi PPDB
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-gray-200 text-base font-bold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 hover:-translate-y-1">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

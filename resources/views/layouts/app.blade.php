<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php $schoolName = $globalSettings['school_name'] ?? 'SDN 001 Kepenuhan'; @endphp
    <title>@yield('title', $schoolName)</title>
    
    <meta name="description" content="@yield('meta_description', 'Portal informasi resmi ' . $schoolName)">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $schoolName)">
    <meta property="og:description" content="@yield('meta_description', 'Portal informasi resmi ' . $schoolName)">
    <meta property="og:image" content="@yield('og_image', ($globalSettings['logo_path'] ?? null) ? Storage::url($globalSettings['logo_path']) : asset('images/default-og.png'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', $schoolName)">
    <meta property="twitter:description" content="@yield('meta_description', 'Portal informasi resmi ' . $schoolName)">
    <meta property="twitter:image" content="@yield('og_image', ($globalSettings['logo_path'] ?? null) ? Storage::url($globalSettings['logo_path']) : asset('images/default-og.png'))">

    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "EducationalOrganization",
        "name": "{{ $schoolName }}",
        "url": "{{ config('app.url') }}",
        @if($globalSettings['logo_path'] ?? null)
        "logo": "{{ Storage::url($globalSettings['logo_path']) }}",
        @endif
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ $globalSettings['address'] ?? '' }}"
        },
        @if($globalSettings['phone'] ?? null)
        "telephone": "{{ $globalSettings['phone'] }}",
        @endif
        @if($globalSettings['email'] ?? null)
        "email": "{{ $globalSettings['email'] }}",
        @endif
        "sameAs": []
    }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 flex flex-col min-h-screen">
    
    <!-- Header / Navbar -->
    <header class="bg-white sticky top-0 z-50 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        @if($globalSettings['logo_path'] ?? null)
                            <img class="h-10 w-auto transition-transform group-hover:scale-105" src="{{ Storage::url($globalSettings['logo_path']) }}" alt="Logo">
                        @else
                            <div class="h-10 w-10 bg-primary-600 rounded-lg flex items-center justify-center text-white font-bold text-xl transition-transform group-hover:scale-105">
                                SD
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-gray-900 leading-tight">{{ $schoolName }}</span>
                            <span class="text-xs text-gray-500">Sekolah Dasar Negeri</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('home') ? 'border-primary-600 text-primary-600' : 'border-transparent' }}">Beranda</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-primary-600 px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('about') ? 'border-primary-600 text-primary-600' : 'border-transparent' }}">Tentang</a>
                    <a href="{{ route('teachers') }}" class="text-gray-600 hover:text-primary-600 px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('teachers') ? 'border-primary-600 text-primary-600' : 'border-transparent' }}">Guru</a>
                    <a href="{{ route('gallery') }}" class="text-gray-600 hover:text-primary-600 px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('gallery') ? 'border-primary-600 text-primary-600' : 'border-transparent' }}">Galeri</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-primary-600 px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('posts.*') ? 'border-primary-600 text-primary-600' : 'border-transparent' }}">Berita</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary-600 px-1 py-2 text-sm font-medium transition-colors border-b-2 {{ request()->routeIs('contact') ? 'border-primary-600 text-primary-600' : 'border-transparent' }}">Kontak</a>
                </nav>

                <!-- Actions / PPDB Button -->
                <div class="hidden md:flex items-center space-x-4">
                    @if(App\Models\Setting::isPpdbOpen())
                        <a href="{{ route('ppdb.info') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-md shadow-primary-500/20 transition-all hover:-translate-y-0.5 animate-pulse">
                            Daftar Anak Anda
                        </a>
                    @endif
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-primary-600 font-medium text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-primary-600 bg-primary-50 hover:bg-primary-100 px-4 py-2 rounded-lg font-medium text-sm transition-colors border border-primary-100">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="hidden h-6 w-6" :class="{'hidden': !mobileMenuOpen, 'block': mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" class="md:hidden border-t border-gray-100 bg-white" 
             x-transition:enter="transition-all ease-out duration-300"
             x-transition:enter-start="opacity-0 max-h-0"
             x-transition:enter-end="opacity-100 max-h-screen"
             x-transition:leave="transition-all ease-in duration-200"
             x-transition:leave-start="opacity-100 max-h-screen"
             x-transition:leave-end="opacity-0 max-h-0">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }}">Beranda</a>
                <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('about') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }}">Tentang</a>
                <a href="{{ route('teachers') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('teachers') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }}">Guru</a>
                <a href="{{ route('gallery') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('gallery') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }}">Galeri</a>
                <a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('posts.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }}">Berita</a>
                <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }}">Kontak</a>
                
                @if(App\Models\Setting::isPpdbOpen())
                    <a href="{{ route('ppdb.info') }}" class="block px-3 py-2 rounded-md text-base font-bold bg-secondary-500 text-white mt-4 text-center">Daftar PPDB</a>
                @endif
                
                <div class="border-t border-gray-200 mt-4 pt-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-primary-600 hover:bg-gray-50 text-center border border-primary-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-primary-600 hover:bg-gray-50 text-center border border-primary-200">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 pt-16 pb-8 text-gray-300 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- About Column -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        @if($globalSettings['logo_path'] ?? null)
                            <img class="h-12 w-auto brightness-0 invert" src="{{ Storage::url($globalSettings['logo_path']) }}" alt="Logo">
                        @else
                            <div class="h-10 w-10 bg-primary-600 rounded flex items-center justify-center text-white font-bold text-xl">SD</div>
                        @endif
                        <span class="font-bold text-xl text-white">{{ $schoolName }}</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md leading-relaxed">
                        Kami berkomitmen untuk memberikan pendidikan terbaik bagi putra-putri Anda, membekali mereka dengan pengetahuan, keterampilan, dan karakter yang kuat untuk masa depan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">YouTube</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-bold text-white tracking-wider uppercase mb-4">Tautan Pantas</h3>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors">Tentang Sekolah</a></li>
                        <li><a href="{{ route('teachers') }}" class="text-gray-400 hover:text-white transition-colors">Direktori Guru</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-gray-400 hover:text-white transition-colors">Galeri Kegiatan</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-gray-400 hover:text-white transition-colors">Berita & Pengumuman</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-sm font-bold text-white tracking-wider uppercase mb-4">Hubungi Kami</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-400 text-sm leading-relaxed">{{ $globalSettings['address'] ?? 'Jl. Utama No. 1, Kepenuhan' }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-primary-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-400 text-sm">{{ $globalSettings['phone'] ?? '081234567890' }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-primary-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:{{ $globalSettings['email'] ?? 'info@sdn001kepenuhan.sch.id' }}" class="text-gray-400 hover:text-white transition-colors text-sm">{{ $globalSettings['email'] ?? 'info@sdn001kepenuhan.sch.id' }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 py-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} {{ $schoolName }}. All rights reserved.
                </p>
                <div class="flex space-x-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>

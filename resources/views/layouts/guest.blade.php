<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SDN 001 Kepenuhan') }} - Portal Autentikasi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased h-full flex flex-col md:flex-row">
    
    <!-- Left Side: Image / Promo -->
    <div class="hidden lg:flex lg:flex-1 lg:flex-col lg:justify-between bg-primary-900 relative overflow-hidden">
        <!-- Background Image -->
        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80" alt="School" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-overlay">
        
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-linear-to-t from-primary-900 via-primary-900/60 to-transparent"></div>
        
        <!-- Decorative accents -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-primary-500 rounded-full mix-blend-multiply opacity-50 blur-3xl"></div>
        
        <div class="relative z-10 p-12 lg:p-20">
            <a href="/" wire:navigate class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md p-3 pr-5 rounded-full border border-white/20 transition hover:bg-white/20">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                </div>
                <span class="text-white font-bold text-lg tracking-wide">SDN 001</span>
            </a>
        </div>

        <div class="relative z-10 p-12 lg:p-20 mt-auto">
            <h1 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 leading-tight font-poppins">
                Masa Depan Cerah <br>Dimulai dari Sini.
            </h1>
            <p class="text-primary-100 text-lg max-w-lg leading-relaxed">
                Bergabunglah bersama kami untuk mencetak generasi penerus yang cerdas, berkarakter, dan berprestasi unggul di tingkat dasar.
            </p>
        </div>
    </div>

    <!-- Right Side: Auth Form -->
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:w-[480px] xl:w-[560px] lg:px-20 xl:px-24 bg-white shadow-[-20px_0_40px_-15px_rgba(0,0,0,0.1)] z-20 min-h-screen">
        <div class="mx-auto w-full max-w-sm lg:w-full">
            
            <!-- Mobile Header/Logo -->
            <div class="lg:hidden text-center mb-8 flex flex-col items-center">
                <a href="/" wire:navigate class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-2xl shadow-lg mb-4 hover:scale-105 transition-transform">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path></svg>
                </a>
                <h2 class="text-2xl font-bold text-gray-900 font-poppins">SDN 001 Kepenuhan</h2>
            </div>
            
            {{ $slot }}
            
        </div>
    </div>

</body>
</html>

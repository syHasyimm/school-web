@extends('layouts.app')

@section('title', 'Hubungi Kami - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Header Banner -->
    <div class="bg-primary-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-primary-900 to-black"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Hubungi Kami</h1>
            <p class="text-xl text-primary-200 max-w-2xl mx-auto">Sampaikan pertanyaan, kritik, maupun saran. Kami siap melayani dengan sepenuh hati.</p>
        </div>
    </div>

    <div class="bg-gray-50 py-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8">
                
                <!-- Contact Info Section -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                    <p class="text-gray-600 mb-8 max-w-lg leading-relaxed">Selain melalui form di samping, Anda juga dapat mengunjungi langsung atau menghubungi staf kami melalui kanal resmi berikut saat jam kerja.</p>
                    
                    <div class="space-y-6">
                        <x-card class="flex items-start p-6 hover:-translate-y-1">
                            <div class="bg-primary-50 p-3 rounded-full text-primary-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Alamat Lengkap</h3>
                                <p class="text-gray-600">{{ \App\Models\Setting::get('address', 'Jalan Utama No. 1, Kecamatan Kepenuhan, Rokan Hulu, Riau') }}</p>
                            </div>
                        </x-card>
                        
                        <x-card class="flex items-start p-6 hover:-translate-y-1">
                            <div class="bg-green-50 p-3 rounded-full text-green-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Telepon & WhatsApp</h3>
                                <p class="text-gray-600">{{ \App\Models\Setting::get('phone', '0812-3456-7890') }}</p>
                                <p class="text-xs text-gray-400 mt-1">Hanya pada jam kerja (Senin - Sabtu, 08.00 - 14.00 WIB)</p>
                            </div>
                        </x-card>
                        
                        <x-card class="flex items-start p-6 hover:-translate-y-1">
                            <div class="bg-blue-50 p-3 rounded-full text-blue-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Email</h3>
                                <p class="text-gray-600">{{ \App\Models\Setting::get('email', 'info@sdn001kepenuhan.sch.id') }}</p>
                            </div>
                        </x-card>
                    </div>
                </div>
                
                <!-- Contact Form Section -->
                <div>
                    <x-card class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Formulir Pesan</h2>
                        <p class="text-gray-500 mb-6 text-sm">Masukan Anda akan terkirim dengan aman ke sistem kami.</p>
                        
                        <livewire:public.contact-form />
                    </x-card>
                </div>
                
            </div>

            <!-- Embed Map if available -->
            @php
                $mapFragment = \App\Models\Setting::get('google_maps_embed', null);
            @endphp
            @if($mapFragment)
            <div class="mt-20">
                <x-section-title title="Lokasi Kami" centered="true" />
                <x-card class="p-2 overflow-hidden h-[400px]">
                    <div class="w-full h-full rounded-xl overflow-hidden [&>iframe]:w-full [&>iframe]:h-full">
                        {!! $mapFragment !!}
                    </div>
                </x-card>
            </div>
            @endif

        </div>
    </div>
@endsection

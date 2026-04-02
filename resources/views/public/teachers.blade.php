@extends('layouts.app')

@section('title', 'Direktori Guru - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Header Banner -->
    <div class="bg-primary-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,var(--tw-gradient-stops))] from-white via-primary-900 to-black"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Direktori Tenaga Pendidik</h1>
                <p class="text-xl text-primary-200 max-w-2xl mx-auto">Mengenal para pahlawan tanpa tanda jasa di {{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}.</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title title="Guru & Staff" />
            
            @if($teachers->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="text-xl text-gray-500 font-medium">Belum ada data tenaga pendidik.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($teachers as $teacher)
                        <div class="group relative block h-full">
                            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-xl hover:shadow-primary-500/10 transition-all duration-500 text-center flex flex-col items-center h-full group-hover:-translate-y-2 relative overflow-hidden">
                                <!-- Abstract decorative shape -->
                                <div class="absolute -top-12 -right-12 w-32 h-32 bg-primary-50 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                                
                                <!-- Image -->
                                <div class="relative w-32 h-32 sm:w-36 sm:h-36 mb-6">
                                    <div class="absolute inset-0 bg-primary-100 rounded-full scale-110 opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                                    <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover rounded-full border-4 border-white shadow-md relative z-10 group-hover:scale-105 transition-transform duration-500">
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 flex flex-col items-center justify-start w-full relative z-10">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors leading-tight">{{ $teacher->full_name }}</h3>
                                    
                                    @if($teacher->nip)
                                        <p class="text-[11px] text-gray-400 font-mono tracking-wider uppercase mb-3">NIP. {{ $teacher->nip }}</p>
                                    @endif
                                    
                                    <div class="mt-auto w-full flex flex-col items-center pt-4">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-primary-50 text-primary-700 tracking-wide border border-primary-100/50 mb-2">
                                            {{ $teacher->position }}
                                        </span>
                                        
                                        <p class="text-sm font-medium text-gray-500 w-full line-clamp-2 min-h-[1.25rem]">{{ $teacher->subject ?? '' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Decorative bottom line -->
                                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-1.5 bg-linear-to-r from-primary-400 to-primary-600 group-hover:w-1/2 transition-all duration-500 rounded-t-full"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12 flex justify-center">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

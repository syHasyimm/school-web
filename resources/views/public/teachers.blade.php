@extends('layouts.app')

@section('title', 'Direktori Guru - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Header Banner -->
    <div class="bg-primary-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-primary-900 to-black"></div>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($teachers as $teacher)
                        <x-card class="group flex flex-col text-center pb-6">
                            <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100 overflow-hidden relative mb-6">
                                @if($teacher->photo_path)
                                    <img src="{{ Storage::url($teacher->photo_path) }}" alt="{{ $teacher->full_name }}" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex justify-center items-center">
                                        <svg class="h-1/2 w-1/2 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                            </div>
                            
                            <div class="px-6 flex-grow flex flex-col items-center">
                                <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $teacher->full_name }}</h3>
                                
                                @if($teacher->nip)
                                    <p class="text-xs text-gray-400 font-mono mb-3 leading-none">{{ $teacher->nip }}</p>
                                @endif
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary-50 text-primary-700 tracking-wide mt-auto">
                                    {{ $teacher->position }}
                                </span>
                                
                                @if($teacher->subject)
                                    <p class="text-sm font-medium text-gray-600 mt-3 pt-3 border-t border-gray-100 w-full">{{ $teacher->subject }}</p>
                                @endif
                            </div>
                        </x-card>
                    @endforeach
                </div>
                
                <div class="mt-12 flex justify-center">
                    {{ $teachers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

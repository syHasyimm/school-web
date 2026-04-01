@extends('layouts.app')

@section('title', 'Berita & Pengumuman - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Header Banner -->
    <div class="bg-primary-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-primary-900 to-black"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Berita & Informasi</h1>
            <p class="text-xl text-primary-200 max-w-2xl mx-auto">Kumpulan berita, artikel, dan pengumuman terbaru dari sekolah.</p>
        </div>
    </div>

    <div class="bg-gray-50 py-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6">
                <!-- Livewire Search Input -->
                <div class="w-full md:w-1/3 relative">
                    <form action="{{ route('posts.index') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 focus:border-primary-500 focus:ring-primary-500 shadow-sm transition-all text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </form>
                </div>
                
                <!-- Category Filter -->
                <div class="flex flex-wrap gap-2 w-full md:w-auto h-full items-center">
                    <a href="{{ route('posts.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('category') ? 'bg-primary-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">Semua</a>
                    @foreach($categories as $category)
                        <a href="{{ route('posts.index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') == $category->slug ? 'bg-primary-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

            @if($posts->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-xl text-gray-500 font-medium">Belum ada berita yang diterbitkan.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <x-card class="flex flex-col h-full group">
                            <a href="{{ route('posts.show', $post->slug) }}" class="relative block h-56 overflow-hidden">
                                @if($post->image_path)
                                    <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <img src="https://images.unsplash.com/photo-1546410531-ea4cea9b7111?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400&q=80" alt="Placeholder" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 filter brightness-90">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                                @if($post->categories->first())
                                    <span class="absolute top-4 left-4 bg-primary-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                        {{ $post->categories->first()->name }}
                                    </span>
                                @endif
                            </a>
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex items-center text-sm text-gray-500 mb-3 space-x-4">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $post->published_at->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-600 mb-4 line-clamp-3 text-sm leading-relaxed">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                                <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-primary-600 font-medium text-sm hover:text-primary-800 flex items-center group-hover:underline">
                                        Baca Selengkapnya
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </a>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>
                
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Galeri Kegiatan - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <!-- Header Banner -->
    <div class="bg-primary-900 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white via-primary-900 to-black"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Galeri Kegiatan</h1>
                <p class="text-xl text-primary-200 max-w-2xl mx-auto">Dokumentasi ragam aktivitas siswa dan sekolah {{ \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan') }}.</p>
            </div>
        </div>
    </div>

    <!-- Alpine X-Data for Lightbox -->
    <div class="bg-gray-50 py-16 min-h-screen" 
         x-data="{ 
            lightboxOpen: false, 
            lightboxImageOffset: 0,
            lightboxImageSrc: '', 
            lightboxImageTitle: '', 
            lightboxImageDesc: '',
            images: [],
            openLightbox(index) {
                this.lightboxImageOffset = index;
                this.updateLightboxContents();
                this.lightboxOpen = true;
                document.body.classList.add('overflow-hidden');
            },
            closeLightbox() {
                this.lightboxOpen = false;
                document.body.classList.remove('overflow-hidden');
            },
            nextImage() {
                this.lightboxImageOffset = (this.lightboxImageOffset + 1) % this.images.length;
                this.updateLightboxContents();
            },
            prevImage() {
                this.lightboxImageOffset = (this.lightboxImageOffset - 1 + this.images.length) % this.images.length;
                this.updateLightboxContents();
            },
            updateLightboxContents() {
                const data = this.images[this.lightboxImageOffset];
                this.lightboxImageSrc = data.src;
                this.lightboxImageTitle = data.title;
                this.lightboxImageDesc = data.desc;
            }
         }"
         x-init="
            images = Array.from(document.querySelectorAll('.gallery-item')).map(el => ({
                src: el.dataset.src,
                title: el.dataset.title,
                desc: el.dataset.desc
            }));
         "
         @keydown.escape.window="closeLightbox()"
         @keydown.arrow-right.window="if(lightboxOpen) nextImage()"
         @keydown.arrow-left.window="if(lightboxOpen) prevImage()">
         
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filter / Menu -->
            @if(count($albums) > 0)
                <div class="flex flex-wrap justify-center gap-3 mb-12">
                    <a href="{{ route('gallery') }}" class="px-6 py-2 rounded-full font-medium text-sm transition-colors {{ is_null($selectedAlbum) ? 'bg-primary-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">Semua</a>
                    @foreach($albums as $album)
                        <a href="{{ route('gallery', ['album' => $album]) }}" class="px-6 py-2 rounded-full font-medium text-sm transition-colors {{ $selectedAlbum === $album ? 'bg-primary-600 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">{{ $album }}</a>
                    @endforeach
                </div>
            @endif

            @if($galleries->isEmpty())
                <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xl text-gray-500 font-medium">Belum ada foto galeri.</p>
                </div>
            @else
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach($galleries as $index => $gallery)
                        <div class="break-inside-avoid shadow-md rounded-2xl overflow-hidden group relative cursor-zoom-in gallery-item"
                             data-src="{{ asset('storage/' . $gallery->image_path) }}"
                             data-title="{{ $gallery->title }}"
                             data-desc="{{ $gallery->description ?? '' }}"
                             @click="openLightbox({{ $index }})">
                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" loading="lazy" class="w-full object-cover transition-transform duration-700 group-hover:scale-105">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                                <h3 class="text-lg font-bold text-white mb-1">{{ $gallery->title }}</h3>
                                @if($gallery->album)
                                    <span class="inline-block text-xs font-semibold text-primary-300 mb-2 uppercase tracking-wide">{{ $gallery->album }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12 flex justify-center">
                    {{ $galleries->links() }}
                </div>
            @endif

        </div>

        <!-- Lightbox Modal -->
        <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-sm" style="display: none;"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <!-- Controls -->
            <button @click="closeLightbox()" class="absolute top-6 right-6 text-white/70 hover:text-white p-2 rounded-full hover:bg-white/10 transition-colors z-[101]">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <button @click.stop="prevImage()" class="absolute left-4 sm:left-10 text-white/70 hover:text-white p-3 rounded-full hover:bg-white/10 transition-colors z-[101] hidden sm:block">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button @click.stop="nextImage()" class="absolute right-4 sm:right-10 text-white/70 hover:text-white p-3 rounded-full hover:bg-white/10 transition-colors z-[101] hidden sm:block">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>

            <!-- Image Container -->
            <div class="relative w-full h-full max-w-6xl p-4 sm:p-10 flex flex-col items-center justify-center cursor-default" @click.self="closeLightbox()">
                <img :src="lightboxImageSrc" class="max-h-[80vh] max-w-full object-contain rounded-lg shadow-2xl" @click.stop="nextImage()">
                <div class="absolute bottom-6 sm:bottom-10 left-0 right-0 text-center pointer-events-none px-4">
                    <h4 x-text="lightboxImageTitle" class="text-white font-bold text-xl drop-shadow-md pb-1"></h4>
                    <p x-text="lightboxImageDesc" class="text-gray-300 text-sm drop-shadow-md max-w-2xl mx-auto hidden sm:block"></p>
                </div>
            </div>
            
        </div>
    </div>
@endsection

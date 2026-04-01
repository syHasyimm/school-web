@extends('layouts.app')

@section('title', $post->title . ' - ' . ($globalSettings['school_name'] ?? 'SDN 001 Kepenuhan'))
@section('meta_description', Str::limit(strip_tags($post->content), 150))

@section('content')
    <div class="bg-gray-50 min-h-screen pt-10 pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-primary-600">
                            <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('posts.index') }}" class="ml-1 text-gray-600 hover:text-primary-600 md:ml-2">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-gray-400 md:ml-2 line-clamp-1">{{ $post->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @if($post->image_path)
                    <div class="w-full h-80 md:h-[450px] relative">
                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                @endif
                
                <div class="p-8 md:p-12">
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($post->categories as $category)
                            <a href="{{ route('posts.index', ['category' => $category->slug]) }}" class="bg-primary-50 text-primary-600 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider hover:bg-primary-100 transition-colors">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-6">
                        {{ $post->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-between border-y border-gray-100 py-4 mb-8">
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                {{ $post->published_at->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-5 h-5 mr-2 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                {{ $post->views_count }} Dilihat
                            </div>
                        </div>
                        <div class="flex items-center text-gray-500 text-sm mt-4 md:mt-0">
                            Ditulis oleh: <span class="font-semibold text-gray-900 ml-1">{{ $post->author->name ?? 'Admin' }}</span>
                        </div>
                    </div>

                    <div class="prose prose-lg prose-primary max-w-none text-gray-700 leading-relaxed prose-img:rounded-xl">
                        {!! $post->content !!}
                    </div>

                    <!-- Share Section -->
                    <div class="mt-12 pt-6 border-t border-gray-100 flex items-center gap-4">
                        <span class="text-gray-500 font-medium">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}" target="_blank" class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center hover:bg-green-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.015 1.83C6.319 1.83 1.7 6.45 1.7 12.146c0 1.84.487 3.596 1.396 5.158l-1.468 5.378 5.485-1.44a10.298 10.298 0 004.885 1.229h.003c5.696 0 10.317-4.619 10.317-10.318A10.301 10.301 0 0012.015 1.83zm0 18.847h-.003a8.56 8.56 0 01-4.364-1.187l-.312-.186-3.245.852.868-3.167-.204-.325A8.557 8.557 0 013.43 12.146C3.43 6.42 7.085 2.766 12 2.766c2.28 0 4.423.889 6.037 2.503a8.497 8.497 0 012.502 6.035c0 4.706-3.829 8.534-8.524 8.534z"/><path fill-rule="evenodd" d="M16.963 14.393c-.274-.138-1.619-.8-1.87-8.892-.251-.091-.433-.138-.616.138-.182.275-.705.892-.865 1.075-.158.183-.317.206-.59.07-.274-.138-1.154-.427-2.197-1.357-.811-.724-1.358-1.618-1.516-1.892-.158-.274-.017-.423.12-.56.124-.124.274-.322.411-.482.138-.16.183-.275.275-.458.093-.183.047-.344-.022-.482-.07-.138-.616-1.487-.843-2.037-.221-.537-.446-.464-.616-.473-.16-.008-.344-.01-.527-.01-.183 0-.482.07-.731.344-.249.275-.953.931-.953 2.27 0 1.339.976 2.634 1.112 2.817.138.183 1.916 2.924 4.64 4.099.648.279 1.154.446 1.549.57.653.205 1.246.176 1.714.106.525-.078 1.619-.661 1.847-1.3.228-.639.228-1.187.16-1.302-.07-.116-.252-.185-.526-.323z" clip-rule="evenodd" /></svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Related Posts -->
            @if($relatedPosts->isNotEmpty())
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Baca Juga Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($relatedPosts as $related)
                        <x-card class="group flex p-4 items-center">
                            <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0">
                                @if($related->image_path)
                                    <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <img src="https://images.unsplash.com/photo-1546410531-ea4cea9b7111?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" alt="Placeholder" class="w-full h-full object-cover grayscale opacity-80 transition-transform duration-500 group-hover:scale-110">
                                @endif
                            </div>
                            <div class="ml-4">
                                <span class="text-xs text-primary-600 font-semibold mb-1 block">{{ $related->published_at->translatedFormat('d M Y') }}</span>
                                <h4 class="text-gray-900 font-bold leading-tight group-hover:text-primary-600 transition-colors line-clamp-2">
                                    <a href="{{ route('posts.show', $related->slug) }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $related->title }}
                                    </a>
                                </h4>
                            </div>
                        </x-card>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Detail Berita')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.posts.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Pratinjau Berita</h2>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            Edit Berita
        </a>
        <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
            Lihat di Web
        </a>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-8 items-start">
    <div class="w-full lg:w-2/3 space-y-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden p-6 sm:p-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 leading-tight">{{ $post->title }}</h1>
            
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-8 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>{{ $post->author->name ?? 'Admin' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>{{ $post->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <span>{{ number_format($post->views_count) }} Views</span>
                </div>
            </div>

            @if($post->image_path)
                <div class="mb-8 rounded-xl overflow-hidden bg-gray-100 shadow-sm border border-gray-200">
                    <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[500px] object-cover">
                </div>
            @endif

            <div class="prose prose-indigo max-w-none prose-p:leading-relaxed prose-p:text-gray-700 prose-headings:text-gray-900 prose-a:text-primary-600 hover:prose-a:text-primary-800 prose-img:rounded-xl prose-img:border prose-img:border-gray-200">
                {!! $post->content !!}
            </div>
            
            <div class="mt-12 pt-6 border-t border-gray-100 flex gap-2 flex-wrap">
                <span class="text-sm font-semibold text-gray-600 mr-2 flex items-center">Kategori:</span>
                @forelse($post->categories as $category)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">{{ $category->name }}</span>
                @empty
                    <span class="text-sm text-gray-400 italic">Tidak ada kategori</span>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="w-full lg:w-1/3 space-y-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden p-6">
            <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Informasi Publikasi</h3>
            
            <dl class="space-y-4 text-sm">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <dt class="text-gray-500 font-medium">Status</dt>
                    <dd>
                        @if($post->is_published)
                            <span class="px-2 py-1 inline-flex text-xs leading-4 font-bold rounded-md bg-green-100 text-green-800">Published</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-4 font-bold rounded-md bg-gray-100 text-gray-800">Draft</span>
                        @endif
                    </dd>
                </div>
                
                @if($post->is_published && $post->published_at)
                    <div class="flex justify-between border-b border-gray-50 pb-2">
                        <dt class="text-gray-500 font-medium">Tgl Terbit</dt>
                        <dd class="text-gray-900 font-semibold">{{ $post->published_at->format('d M Y H:i') }}</dd>
                    </div>
                @endif
                
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <dt class="text-gray-500 font-medium">Tgl Dibuat</dt>
                    <dd class="text-gray-900">{{ $post->created_at->format('d M Y H:i') }}</dd>
                </div>
                
                <div class="flex justify-between">
                    <dt class="text-gray-500 font-medium">Tgl Update</dt>
                    <dd class="text-gray-900">{{ $post->updated_at->format('d M Y H:i') }}</dd>
                </div>
            </dl>
            
            <form action="{{ route('admin.posts.update', $post) }}" method="POST" class="mt-6 pt-4 border-t border-gray-100">
                @csrf
                @method('PUT')
                <input type="hidden" name="title" value="{{ $post->title }}">
                <input type="hidden" name="content" value="{{ $post->content }}">
                @if($post->excerpt)
                    <input type="hidden" name="excerpt" value="{{ $post->excerpt }}">
                @endif
                @foreach($post->categories as $cat)
                    <input type="hidden" name="categories[]" value="{{ $cat->id }}">
                @endforeach
                
                <input type="hidden" name="is_published" value="{{ $post->is_published ? '0' : '1' }}">
                <button type="submit" class="w-full flex justify-center items-center gap-2 px-4 py-2 border {{ $post->is_published ? 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50' : 'border-transparent text-white bg-green-600 hover:bg-green-700' }} rounded-lg text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $post->is_published ? 'focus:ring-gray-500' : 'focus:ring-green-500' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $post->is_published ? 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M5 13l4 4L19 7' }}" />
                    </svg>
                    {{ $post->is_published ? 'Tarik jadi Draft' : 'Terbitkan Sekarang' }}
                </button>
            </form>
        </div>
        
        <div class="bg-gray-50 border border-gray-200 shadow-sm rounded-2xl overflow-hidden p-6">
            <h3 class="font-bold text-gray-900 border-b border-gray-200 pb-3 mb-4">Excerpt (Ringkasan)</h3>
            <p class="text-sm text-gray-600 leading-relaxed italic">
                "{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}"
            </p>
        </div>
    </div>
</div>
@endsection

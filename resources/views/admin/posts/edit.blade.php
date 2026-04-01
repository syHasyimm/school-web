@extends('layouts.admin')

@section('title', 'Edit Berita: ' . Str::limit($post->title, 30))

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
    }
    trix-editor {
        min-height: 300px !important;
        background-color: white;
        border-color: #d1d5db !important;
        border-radius: 0.5rem;
        padding: 1rem;
    }
    trix-editor:focus {
        border-color: #0ea5e9 !important;
        box-shadow: 0 0 0 1px #0ea5e9 !important;
        outline: none;
    }
</style>
@endpush

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.posts.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Edit Berita</h2>
    </div>
</div>

<div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Content Area -->
            <div class="flex-1 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required autofocus
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-lg px-4 py-3 placeholder-gray-400">
                    @error('title')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-semibold text-gray-700 mb-1">Ringkasan (Excerpt) <span class="text-gray-400 font-normal ml-1">Kopsional</span></label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-3">{{ old('excerpt', $post->excerpt) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Akan tampil sebagai cuplikan pada daftar berita. Jika dikosongkan, paragraf awal konten akan diambil otomatis.</p>
                    @error('excerpt')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content with Trix -->
                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-1">Isi Berita <span class="text-red-500">*</span></label>
                    <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                    <trix-editor input="content" class="prose max-w-none text-sm"></trix-editor>
                    @error('content')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Sidebar Area -->
            <div class="w-full lg:w-80 space-y-6">
                
                <!-- Status & Publish -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Status Publikasi</h3>
                    
                    <div class="space-y-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="hidden" name="is_published" value="0">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 inline-block transition-colors shrink-0"></div>
                                <span class="ml-3 text-sm font-semibold text-gray-700 select-none">Terbitkan Sekarang</span>
                            </div>
                        </label>
                        <p class="text-xs text-gray-500 leading-relaxed">Jika dimatikan (draft), berita ini tidak akan muncul di halaman publik.</p>
                        
                        @if($post->published_at)
                            <p class="text-xs text-green-600 bg-green-50 p-2 rounded border border-green-100 mt-2">Diterbitkan pada: {{ $post->published_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Kategori Berita</h3>
                    
                    <div class="max-h-48 overflow-y-auto pr-2 space-y-2">
                        @php $postCategories = old('categories', $post->categories->pluck('id')->toArray()); @endphp
                        @forelse($categories as $category)
                            <label class="flex items-center">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 h-4 w-4"
                                    {{ in_array($category->id, $postCategories) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 truncate" title="{{ $category->name }}">{{ $category->name }}</span>
                            </label>
                        @empty
                            <p class="text-xs text-gray-500 italic pb-2">Belum ada kategori yang dibuat.</p>
                            <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-primary-600 hover:text-primary-800 transition">Buat Kategori Baru &rarr;</a>
                        @endforelse
                    </div>
                </div>

                <!-- Thumbnail Image -->
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-5" x-data="imagePreview('{{ $post->image_path ? Storage::url($post->image_path) : '' }}')">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">Gambar Utama (Thumbnail)</h3>
                    
                    <div class="mt-2 text-center">
                        <div x-show="!imageUrl" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-white relative hover:bg-gray-50 transition cursor-pointer" @click="$refs.fileInput.click()" style="display: none;">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <span class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                        Pilih Gambar
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, WEBP maks 2MB</p>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div x-show="imageUrl" class="relative rounded-lg overflow-hidden border border-gray-200 shadow-sm transition">
                            <img :src="imageUrl" class="w-full h-40 object-cover" alt="Preview Image">
                            <button type="button" @click="removeImage" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1.5 hover:bg-red-700 shadow-md transition focus:outline-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        
                        <input type="file" name="image" id="image" class="sr-only" accept="image/jpeg,image/png,image/webp" x-ref="fileInput" @change="fileChosen">
                    </div>
                    @error('image')
                        <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 active:bg-primary-800 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Perbarui Berita
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    });

    function imagePreview(existingUrl) {
        return {
            imageUrl: existingUrl,
            
            fileChosen(event) {
                this.fileToDataUrl(event, src => this.imageUrl = src)
            },

            fileToDataUrl(event, callback) {
                if (! event.target.files.length) return
                
                let file = event.target.files[0],
                    reader = new FileReader()
                
                reader.readAsDataURL(file)
                reader.onload = e => callback(e.target.result)
            },

            removeImage() {
                this.imageUrl = '';
                this.$refs.fileInput.value = '';
            }
        }
    }
</script>
@endpush

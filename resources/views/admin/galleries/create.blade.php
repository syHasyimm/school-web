@extends('layouts.admin')

@section('title', 'Tambah Foto Galeri')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.galleries.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Unggah Foto Baru</h2>
    </div>
</div>

<div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden max-w-4xl">
    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
        @csrf
        
        <div class="space-y-6">
            
            <div x-data="imagePreview()">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Gambar <span class="text-red-500">*</span></label>
                
                <div x-show="!imageUrl" class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-white transition cursor-pointer" @click="$refs.fileInput.click()">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        <div class="flex flex-col text-sm text-gray-600 justify-center">
                            <span class="relative cursor-pointer bg-transparent rounded-md font-bold text-primary-600 focus-within:outline-none">
                                Klik untuk mengunggah dari komputer
                            </span>
                            <p class="text-xs text-gray-500 mt-2">Mendukung format PNG, JPG, WEBP hingga maksimal 5MB. Dimensi direkomendasikan 1920x1080px.</p>
                        </div>
                    </div>
                </div>

                <div x-show="imageUrl" class="relative rounded-xl overflow-hidden border-2 border-primary-200 shadow-sm max-w-lg mb-4" style="display: none;">
                    <img :src="imageUrl" class="w-full object-contain bg-gray-100" style="max-height: 300px;" alt="Preview Image">
                    <button type="button" @click="removeImage" class="absolute top-3 right-3 bg-red-600 text-white rounded-lg p-2 hover:bg-red-700 shadow-lg transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-gray-900/60 p-3 pt-6 pointer-events-none">
                        <p class="text-white text-sm font-medium" x-text="fileName"></p>
                    </div>
                </div>
                
                <input type="file" name="image" id="image" class="sr-only" accept="image/jpeg,image/png,image/webp" x-ref="fileInput" @change="fileChosen">
                @error('image')
                    <p class="mt-1.5 text-sm text-red-600 font-medium pb-2">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ addAlbum: false }">
                <label for="album" class="block text-sm font-semibold text-gray-700 mb-1">Grup Album (Opsional)</label>
                
                <div x-show="!addAlbum" class="flex gap-2">
                    <select name="album" id="album" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4">
                        <option value="">-- Tanpa Album (Umum) --</option>
                        @foreach($albums as $album)
                            @if($album)
                                <option value="{{ $album }}" {{ old('album') === $album ? 'selected' : '' }}>{{ $album }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="button" @click="addAlbum = true; document.getElementById('album').name = ''; document.getElementById('new_album').name = 'album';" class="px-3 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium whitespace-nowrap transition">
                        + Baru
                    </button>
                </div>
                
                <div x-show="addAlbum" style="display: none;" class="flex gap-2">
                    <input type="text" id="new_album" name="" placeholder="Ketik nama album baru..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4">
                    <button type="button" @click="addAlbum = false; document.getElementById('new_album').name = ''; document.getElementById('album').name = 'album';" class="px-3 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg text-red-600 text-sm font-medium transition">
                        Batal
                    </button>
                </div>
                
                <p class="mt-1 text-xs text-gray-500">Kumpulkan foto-foto terkait dalam album yang sama (contoh: "17 Agustus 2026").</p>
                @error('album')
                    <p class="mt-1.5 text-sm text-red-600 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul / Keterangan Singkat <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" placeholder="Siswa sedang belajar di laboratorium komputer">
                @error('title')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Narasi Panjang (Opsional)</label>
                <textarea name="description" id="description" rows="3"
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-3" placeholder="Sertakan detail lebih lanjut yang mendeskripsikan konteks dokumentasi di atas...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">Urutan (Sort Order)</label>
                <input type="number" name="order" id="order" value="{{ old('order', '0') }}" min="0"
                    class="block w-32 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2">
                <p class="mt-1 text-xs text-gray-500">Semakin kecil angkanya, gambar akan tampil lebih dulu (0 = paling awal).</p>
                @error('order')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 active:bg-primary-800 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Mulai Upload
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function imagePreview() {
        return {
            imageUrl: '',
            fileName: '',
            
            fileChosen(event) {
                if (! event.target.files.length) return
                
                let file = event.target.files[0]
                this.fileName = file.name
                
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = e => this.imageUrl = e.target.result
            },

            removeImage() {
                this.imageUrl = '';
                this.fileName = '';
                this.$refs.fileInput.value = '';
            }
        }
    }
</script>
@endpush

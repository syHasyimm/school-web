@extends('layouts.admin')

@section('title', 'Edit Foto Galeri: ' . Str::limit($gallery->title, 20))

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.galleries.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Ubah Informasi Foto</h2>
    </div>
</div>

<div class="flex flex-col xl:flex-row gap-8 items-start">
    <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden w-full xl:w-2/3">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Replace Image Section -->
                <div x-data="imagePreview('{{ $gallery->image_url }}')" class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                    <label class="block text-sm font-semibold text-gray-900 mb-3 border-b border-gray-200 pb-2">Ganti Gambar (Opsional)</label>
                    <div class="flex flex-col sm:flex-row gap-5 items-start">
                        
                        <div x-show="imageUrl" class="relative rounded-lg overflow-hidden border border-gray-300 shadow-sm shrink-0 bg-white" style="width: 200px;">
                            <img :src="imageUrl" class="w-full object-cover aspect-video" alt="Current Image">
                            <button type="button" @click="removeImage" x-show="imageUrl !== '{{ $gallery->image_url }}'" class="absolute top-1.5 right-1.5 bg-red-600 text-white rounded-md p-1 hover:bg-red-700 shadow-md transition focus:outline-none">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                            <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-gray-900/70 text-[10px] text-white font-mono uppercase" x-text="imageUrl === '{{ $gallery->image_url }}' ? 'Foto Asli' : 'Foto Baru'"></span>
                        </div>

                        <div class="flex-1 w-full">
                            <button type="button" @click="$refs.fileInput.click()" class="w-full flex justify-center items-center gap-2 px-4 py-3 border-2 border-primary-300 border-dashed rounded-lg bg-primary-50 text-sm font-medium text-primary-700 hover:bg-primary-100 transition focus:outline-none">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                Upload Gambar Baru
                            </button>
                            <input type="file" name="image" id="image" class="sr-only" accept="image/jpeg,image/png,image/webp" x-ref="fileInput" @change="fileChosen" />
                            <p class="text-xs text-gray-500 mt-2 leading-relaxed">Pilih file berformat PNG, JPG, WEBP maks 5MB jika Anda ingin mengganti gambar dokumentasi saat ini.</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Inputs -->
                <div x-data="{ addAlbum: false }">
                    <label for="album" class="block text-sm font-semibold text-gray-700 mb-1">Album / Kategori Galeri</label>
                    <div x-show="!addAlbum" class="flex gap-2">
                        <select name="album" id="album" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4">
                            <option value="">-- Tanpa Album --</option>
                            @foreach($albums as $album)
                                @if($album)
                                    <option value="{{ $album }}" {{ old('album', $gallery->album) === $album ? 'selected' : '' }}>{{ $album }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="button" @click="addAlbum = true; document.getElementById('album').name = ''; document.getElementById('new_album').name = 'album';" class="px-3 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium transition whitespace-nowrap">
                            + Buat Baru
                        </button>
                    </div>
                    
                    <div x-show="addAlbum" style="display: none;" class="flex gap-2">
                        <input type="text" id="new_album" name="" placeholder="Ketik nama album baru..." class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4">
                        <button type="button" @click="addAlbum = false; document.getElementById('new_album').name = ''; document.getElementById('album').name = 'album';" class="px-3 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg text-red-600 text-sm font-medium transition">
                            Batal Bikin Baru
                        </button>
                    </div>
                </div>

                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul / Keterangan Gambar <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2" placeholder="Nama kegiatan atau momen...">
                    @error('title')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi & Cerita di Balik Gambar</label>
                    <textarea name="description" id="description" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-3">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-1">Posisi Tampil (Urutan ke-)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $gallery->order) }}" min="0" required
                        class="block w-32 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-3">
                <a href="{{ route('admin.galleries.index') }}" class="px-5 py-2 text-sm font-semibold text-gray-700 hover:text-gray-900 transition">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg text-sm font-semibold text-white hover:bg-primary-700 active:bg-primary-800 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Perbarui Foto
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi / Petunjuk -->
    <div class="w-full xl:w-1/3 space-y-4">
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 shadow-sm text-indigo-900">
            <h4 class="font-bold flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Tips Menyusun Album!
            </h4>
            <p class="text-sm opacity-80 leading-relaxed mb-3">Foto akan dikelompokkan otomatis berdasarkan <strong class="bg-white px-1 py-0.5 rounded text-indigo-600 font-bold">Nama Album</strong> yang persis sama. Pastikan penulisan huruf besar dan kecil seragam.</p>
            <p class="text-sm opacity-80 leading-relaxed">Berikan gambar prioritas tertinggi (<strong class="bg-indigo-100 px-1 py-0.5 rounded">urutan: 0</strong>) agar muncul di posisi teratas web sekolah.</p>
        </div>
        
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm text-center">
            <h4 class="text-sm font-bold text-gray-500 mb-2 uppercase tracking-wide">Gambar Terpublikasi Sejak</h4>
            <p class="text-xl font-mono text-gray-900">{{ $gallery->created_at->format('d/m/Y') }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $gallery->created_at->diffForHumans() }}</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function imagePreview(existingUrl) {
        return {
            imageUrl: existingUrl,
            
            fileChosen(event) {
                if (! event.target.files.length) return
                
                let file = event.target.files[0]
                
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = e => this.imageUrl = e.target.result
            },

            removeImage() {
                this.imageUrl = existingUrl; // Reset ke gambar asli jika dibatalkan
                this.$refs.fileInput.value = '';
            }
        }
    }
</script>
@endpush

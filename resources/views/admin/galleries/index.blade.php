@extends('layouts.admin')

@section('title', 'Galeri Sekolah')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500">Koleksi dokumentasi kegiatan, fasilitas, dan prestasi.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Foto Baru
        </a>
    </div>
</div>

<!-- Filter Box -->
<div class="bg-white rounded-t-2xl shadow-sm border border-gray-200 p-4 border-b-0 space-y-4">
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm font-semibold text-gray-700 mr-2">Filter Album:</span>
        <a href="{{ route('admin.galleries.index') }}" class="px-3 py-1.5 rounded-full text-xs font-medium transition {{ !request('album') ? 'bg-primary-100 text-primary-700 ring-1 ring-primary-500' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            Semua Album
        </a>
        @foreach($albums as $albumItem)
            <a href="{{ route('admin.galleries.index', ['album' => $albumItem]) }}" class="px-3 py-1.5 rounded-full text-xs font-medium transition {{ request('album') === $albumItem ? 'bg-primary-100 text-primary-700 ring-1 ring-primary-500' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $albumItem ?: 'Tanpa Album' }}
            </a>
        @endforeach
    </div>
    <div class="flex items-center gap-2 text-xs text-gray-400">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /></svg>
        <span>Seret dan lepas foto untuk mengubah urutan tampilan</span>
    </div>
</div>

<!-- Grid Container -->
<div class="bg-gray-50 border border-gray-200 shadow-sm rounded-b-2xl p-4 sm:p-6 mb-6">
    <div id="sortable-gallery" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($galleries as $gallery)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col group hover:shadow-md transition" data-id="{{ $gallery->id }}">
                <div class="relative h-48 w-full bg-gray-200 overflow-hidden">
                    <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-linear-to-t from-gray-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <!-- Drag Handle -->
                    <div class="drag-handle absolute top-3 left-3 p-1.5 bg-white/90 text-gray-500 rounded-lg shadow-sm cursor-grab active:cursor-grabbing opacity-100 lg:opacity-0 group-hover:opacity-100 transition hover:bg-white">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" /></svg>
                    </div>

                    <div class="absolute top-3 right-3 flex justify-end gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('admin.galleries.edit', $gallery) }}" class="p-1.5 bg-white text-indigo-600 hover:bg-indigo-50 rounded-lg shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 bg-white text-red-600 hover:bg-red-50 rounded-lg shadow-sm" title="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="p-4 flex-1 flex flex-col">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-bold text-gray-900 text-base leading-tight">{{ $gallery->title }}</h3>
                    </div>
                    @if($gallery->album)
                        <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-semibold rounded-md border border-gray-200 mb-2 w-max">
                            Album: {{ $gallery->album }}
                        </span>
                    @endif
                    <p class="text-sm text-gray-500 mb-3 flex-1 line-clamp-2">
                        {{ $gallery->description ?? 'Tanpa deskripsi' }}
                    </p>
                    <div class="mt-auto text-xs text-gray-400 font-mono flex justify-between items-center pt-3 border-t border-gray-100">
                        <span>Urutan: {{ $gallery->order }}</span>
                        <span>{{ $gallery->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <h3 class="text-lg font-medium text-gray-900">Belum Ada Foto</h3>
                <p class="text-gray-500 mt-1 mb-6 text-center max-w-sm">Galeri dokumentasi sekolah masih kosong. Tambahkan foto pertama Anda.</p>
                <a href="{{ route('admin.galleries.create') }}" class="px-4 py-2 bg-primary-600 text-white rounded-lg font-medium shadow-sm hover:bg-primary-700 transition">
                    Unggah Foto Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="mt-8 pt-4 border-t border-gray-200">
            {{ $galleries->withQueryString()->links() }}
        </div>
    @endif
</div>

<!-- Reorder Toast -->
<div id="reorder-toast" class="fixed bottom-6 right-6 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium z-50 flex items-center gap-2 transition-all duration-300 opacity-0 translate-y-4 pointer-events-none">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
    Urutan berhasil diperbarui!
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-gallery');
    if (!el) return;

    Sortable.create(el, {
        animation: 200,
        handle: '.drag-handle',
        ghostClass: 'opacity-40',
        chosenClass: 'ring-2 ring-primary-500 ring-offset-2',
        onEnd: function () {
            const order = Array.from(el.children)
                .filter(child => child.dataset.id)
                .map(child => parseInt(child.dataset.id));

            fetch('{{ route("admin.galleries.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ order: order }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const toast = document.getElementById('reorder-toast');
                    toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
                    toast.classList.add('opacity-100', 'translate-y-0');
                    setTimeout(() => {
                        toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
                        toast.classList.remove('opacity-100', 'translate-y-0');
                    }, 2500);
                }
            })
            .catch(err => console.error('Reorder failed:', err));
        }
    });
});
</script>
@endpush

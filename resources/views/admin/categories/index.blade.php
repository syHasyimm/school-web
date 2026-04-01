@extends('layouts.admin')

@section('title', 'Kategori Artikel')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.posts.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Manajemen Kategori</h2>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Table Categories -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">Daftar Kategori</h3>
                <span class="bg-primary-100 text-primary-700 text-xs font-bold px-2.5 py-1 rounded-full">{{ $categories->count() }} Total</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Nama Kategori</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Slug (URL)</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-center">Jml Artikel</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" x-data="{ editingId: null }">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors" x-show="editingId !== {{ $category->id }}">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-gray-500">{{ $category->slug }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none {{ $category->posts_count > 0 ? 'text-indigo-700 bg-indigo-100' : 'text-gray-500 bg-gray-100' }} rounded-full">{{ $category->posts_count }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button @click="editingId = {{ $category->id }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-1.5 rounded-md transition" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua artikel dalam kategori ini tidak akan terhapus namun kehilangan relasinya.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Edit Inline Form -->
                            <tr x-show="editingId === {{ $category->id }}" x-cloak style="display: none;" class="bg-indigo-50/50">
                                <td colspan="4" class="px-6 py-4 px-l border-y border-indigo-100">
                                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="flex items-center gap-4">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex-1">
                                            <input type="text" name="name" value="{{ $category->name }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-1.5 px-3 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Simpan</button>
                                            <button type="button" @click="editingId = null" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-1.5 px-3 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Batal</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                        <p class="text-sm font-medium text-gray-900">Belum ada kategori</p>
                                        <p class="text-xs text-gray-500 mt-1">Silakan tambahkan kategori baru melalui form di samping.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Sidebar (Create Form) -->
    <div class="lg:col-span-1">
        <div class="bg-primary-50 border border-primary-100 shadow-sm rounded-2xl overflow-hidden p-6 sticky top-6">
            <h3 class="text-lg font-bold text-primary-900 border-b border-primary-200 pb-3 mb-4">Tambah Kategori Baru</h3>
            
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-primary-800 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required autofocus placeholder="Contoh: Pengumuman"
                            class="block w-full rounded-lg border-primary-300 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm px-4 py-2.5">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition shadow-sm mt-2">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Simpan Kategori
                    </button>
                    <p class="text-xs text-primary-600/70 text-center mt-3">Slug (URL) akan dihasilkan secara otomatis berdasarkan nama kategori secara aman.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

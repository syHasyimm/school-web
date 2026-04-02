@extends('layouts.admin')

@section('title', 'Kotak Masuk (Pesan User)')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500">Kumpulan pertanyaan, saran, dan pesan kontak dari pengunjung website.</p>
    </div>
    <div class="flex gap-2 bg-indigo-50 border border-indigo-100 rounded-lg px-4 py-2">
        <span class="text-xs text-indigo-700 font-semibold uppercase tracking-widest"><span class="bg-indigo-600 text-white rounded-md px-2 py-0.5 text-[10px] mr-1">{{ $unreadCount }}</span> Pesan Baru Belum Dibaca</span>
    </div>
</div>

<div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left pl-7">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Identitas Pengirim</span>
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Subjek & Cuplikan Pesan</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Diterima</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($contacts as $contact)
                    <tr class="{{ !$contact->is_read ? 'bg-blue-50/40' : 'hover:bg-gray-50' }} transition-colors relative group">
                        
                        <td class="px-6 py-4 whitespace-nowrap pl-7 relative">
                            @if(!$contact->is_read)
                                <span class="absolute left-2 top-1/2 -translate-y-1/2 w-2 h-2 bg-blue-600 rounded-full" title="Belum dibaca"></span>
                            @endif
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 sm:h-12 sm:w-12 rounded-full overflow-hidden {{ !$contact->is_read ? 'bg-primary-100' : 'bg-gray-100 border border-gray-200' }} flex items-center justify-center">
                                    <span class="{{ !$contact->is_read ? 'text-primary-700' : 'text-gray-500' }} font-bold text-lg font-mono">{{ substr($contact->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold {{ !$contact->is_read ? 'text-gray-900' : 'text-gray-700' }}">{{ $contact->name }}</div>
                                    <div class="text-xs {{ !$contact->is_read ? 'text-gray-600' : 'text-gray-500' }} mt-1 flex items-center gap-1">
                                        {{ $contact->email }}
                                    </div>
                                    @if($contact->phone)
                                        <div class="text-[11px] text-gray-400 font-mono mt-0.5">{{ $contact->phone }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="block">
                                <div class="text-sm font-bold {{ !$contact->is_read ? 'text-gray-900 group-hover:text-primary-600' : 'text-gray-800 group-hover:text-gray-600' }} transition">{{ $contact->subject }}</div>
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2 max-w-md leading-relaxed pr-4">
                                    {{ Str::limit($contact->message, 150) }}
                                </div>
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                            <p class="font-medium {{ !$contact->is_read ? 'text-gray-900' : 'text-gray-500' }}">{{ $contact->created_at->format('d M Y') }}</p>
                            <p class="text-[11px] text-gray-400 mt-1">{{ $contact->created_at->format('H:i') }}</p>
                            @if(!$contact->is_read && $contact->created_at->diffInDays(now()) < 5)
                                <span class="bg-red-100 text-red-600 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold mt-1 inline-block">Baru</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-2">
                                @if(!$contact->is_read)
                                <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-blue-600 hover:text-blue-900 p-2 border border-transparent hover:border-blue-200 hover:bg-blue-50 rounded-lg transition text-xs" title="Tandai Dibaca">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </button>
                                </form>
                                @endif
                                
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="text-gray-600 hover:text-gray-900 bg-gray-50 border border-gray-200 hover:bg-white p-2 flex items-center rounded-lg transition" title="Buka Pesan">
                                    <span class="text-xs mr-1 pl-1">Buka</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <p class="text-sm font-bold text-gray-900 mb-1">Tidak ada pesan masuk</p>
                                <p class="text-xs text-gray-500 max-w-sm">Kotak masuk (Inbox) surat daring Anda kosong. Tunggu sampai ada pengguna menanyakan info melalui halaman publik 'Kontak'.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($contacts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection

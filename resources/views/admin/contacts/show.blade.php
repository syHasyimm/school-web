@extends('layouts.admin')

@section('title', 'Detail Pesan Masuk')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.contacts.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Membaca Surat / Pesan</h2>
    </div>
    
    <div class="flex gap-2">
        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Hapus pesan kontak ini selamanya?');">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-red-300 rounded-lg font-semibold text-xs text-red-600 uppercase tracking-widest hover:bg-red-50 hover:border-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Hapus Pesan
            </button>
        </form>
    </div>
</div>

<div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden max-w-4xl">
    
    <!-- Meta Sender Header -->
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between gap-5 sm:items-center">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-full bg-indigo-100 text-indigo-700 font-bold text-2xl font-mono flex items-center justify-center shrink-0 border border-indigo-200 shadow-xs">
                {{ substr($contact->name, 0, 1) }}
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $contact->name }}</h3>
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 mt-1 text-sm text-gray-600 font-medium">
                    <a href="mailto:{{ $contact->email }}" class="hover:text-primary-600 hover:underline flex items-center gap-1.5 transition">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        {{ $contact->email }}
                    </a>
                    @if($contact->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}" target="_blank" class="hover:text-green-600 hover:underline flex items-center gap-1.5 transition">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        {{ $contact->phone }}
                        <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold ml-1">WA</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="text-left sm:text-right shrink-0">
            <p class="text-sm font-semibold text-gray-900">{{ $contact->created_at->format('d M Y') }}</p>
            <p class="text-xs text-gray-500">{{ $contact->created_at->format('H:i') }} WIB ({{ $contact->created_at->diffForHumans() }})</p>
        </div>
    </div>
    
    <!-- Subject Area -->
    <div class="px-6 sm:px-10 py-6 border-b border-gray-100 bg-white">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 font-mono">Terkait Perihal:</p>
        <h4 class="text-xl sm:text-2xl font-bold text-gray-800 leading-snug">{{ $contact->subject }}</h4>
    </div>
    
    <!-- Extracted Message Text -->
    <div class="px-6 sm:px-10 py-8 bg-white min-h-[250px]">
        <div class="prose max-w-none text-gray-700 text-base leading-relaxed whitespace-pre-wrap font-sans">
            {{ $contact->message }}
        </div>
    </div>
    
    <!-- Footer / Reply Hints -->
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 rounded-b-2xl">
        <p class="text-xs text-gray-500 order-2 sm:order-1 text-center sm:text-left">
            Balasan harus dikirim luar sistem (melalui email klien Anda/WhatsApp).
        </p>
        <div class="flex gap-3 w-full sm:w-auto order-1 sm:order-2">
            <a href="mailto:{{ $contact->email }}?subject=Balasan: {{ $contact->subject }}" class="flex-1 sm:flex-none flex items-center justify-center px-4 py-2 border border-blue-300 text-blue-700 bg-blue-50 hover:bg-blue-100 hover:border-blue-400 rounded-lg text-sm font-semibold transition focus:outline-none shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Balas via Email
            </a>
            @if($contact->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}?text=Halo%20{{ urlencode($contact->name) }},%20mengacu%20pada%20pesan%20Anda%20di%20Website%20SDN001..." target="_blank" class="flex-1 sm:flex-none flex items-center justify-center px-4 py-2 border border-green-300 text-green-700 bg-green-50 hover:bg-green-100 hover:border-green-400 rounded-lg text-sm font-semibold transition focus:outline-none shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                Balas via WA
            </a>
            @endif
        </div>
    </div>
    
</div>
@endsection

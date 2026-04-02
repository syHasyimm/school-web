@extends('layouts.admin')

@section('title', 'Manajemen Pendafar PPDB')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500">Kelola dan verifikasi data calon peserta didik baru.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.ppdb.export', ['status' => request('status', 'all')]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Export Excel
        </a>
    </div>
</div>

<!-- Statistik Singkat -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('admin.ppdb.index') }}" class="bg-white p-4 rounded-xl shadow-sm border {{ !request('status') ? 'border-primary-500 ring-1 ring-primary-500' : 'border-gray-200 hover:border-primary-300' }} transition-all flex justify-between items-center">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Semua</p>
            <p class="text-2xl font-bold text-gray-900">{{ $counts['total'] }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        </div>
    </a>
    
    <a href="{{ route('admin.ppdb.index', ['status' => 'pending']) }}" class="bg-white p-4 rounded-xl shadow-sm border {{ request('status') === 'pending' ? 'border-amber-500 ring-1 ring-amber-500' : 'border-gray-200 hover:border-amber-300' }} transition-all flex justify-between items-center">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Pending</p>
            <p class="text-2xl font-bold text-gray-900">{{ $counts['pending'] }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
        </div>
    </a>
    
    <a href="{{ route('admin.ppdb.index', ['status' => 'accepted']) }}" class="bg-white p-4 rounded-xl shadow-sm border {{ request('status') === 'accepted' ? 'border-green-500 ring-1 ring-green-500' : 'border-gray-200 hover:border-green-300' }} transition-all flex justify-between items-center">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Diterima</p>
            <p class="text-2xl font-bold text-gray-900">{{ $counts['accepted'] }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-500">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        </div>
    </a>
    
    <a href="{{ route('admin.ppdb.index', ['status' => 'rejected']) }}" class="bg-white p-4 rounded-xl shadow-sm border {{ request('status') === 'rejected' ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-200 hover:border-red-300' }} transition-all flex justify-between items-center">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase">Ditolak</p>
            <p class="text-2xl font-bold text-gray-900">{{ $counts['rejected'] }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </div>
    </a>
</div>

<!-- Filter & Search Box -->
<div class="bg-white rounded-t-2xl shadow-sm border border-gray-200 p-4 border-b-0">
    <form method="GET" action="{{ route('admin.ppdb.index') }}" class="flex flex-col sm:flex-row gap-4">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau kode pendaftaran..." class="pl-10 py-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
        </div>
        <div>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Cari Data
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.ppdb.index') }}" class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Container -->
<div class="bg-white border border-gray-200 shadow-sm rounded-b-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Profil Siswa
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Kode / Tgl Daftar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Kontak & Asal
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Status Verifikasi
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($students as $student)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center font-bold text-gray-500 border border-gray-200">
                                    @php
                                        $photoDoc = $student->documents->where('type', 'foto')->first();
                                    @endphp
                                    @if($photoDoc)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($photoDoc->file_path) }}" alt="">
                                    @else
                                        {{ substr($student->full_name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $student->full_name }} <span class="text-xs font-normal text-gray-500">({{ $student->gender }})</span></div>
                                    <div class="text-xs text-gray-500">NIK: {{ $student->nik }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono font-medium text-primary-600">{{ $student->registration_code }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $student->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $student->parent_phone }}</div>
                            <div class="text-xs text-gray-500 truncate mt-1 w-48" title="{{ $student->previous_school ?? 'Belum ada asal sekolah' }}">{{ $student->previous_school ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(is_array($student->status) || is_object($student->status))
                                @php $statusVal = $student->status->value ?? $student->status; @endphp
                            @else
                                @php $statusVal = $student->status; @endphp
                            @endif

                            @if($statusVal === 'pending')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5 animate-pulse"></span> Pending
                                </span>
                            @elseif($statusVal === 'accepted')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Diterima
                                </span>
                            @elseif($statusVal === 'rejected')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('admin.ppdb.show', $student) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Detail & Verifikasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <p class="text-sm font-medium text-gray-900">Tidak ada data pendaftar</p>
                                <p class="text-xs text-gray-500 mt-1">Belum ada siswa yang mendaftar atau tidak ada hasil dari pencarian.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($students->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $students->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

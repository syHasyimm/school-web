@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500">Pantau seluruh jejak aktivitas administratif untuk keperluan audit trail.</p>
    </div>
</div>

<!-- Filter Box -->
<div class="bg-white rounded-t-2xl shadow-sm border border-gray-200 p-4 border-b-0 space-y-4">
    <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-col sm:flex-row flex-wrap gap-4 items-end">
        
        <div class="w-full sm:w-48">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Jenis Aksi</label>
            <select name="action" class="block w-full py-2 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <option value="">Semua Aksi</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ $action }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="w-full sm:w-48">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5 ml-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="block w-full py-2 rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        </div>
        
        <div>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition shadow-sm h-[38px]">
                Filter Data
            </button>
            @if(request('action') || request('date') || request('user_id'))
                <a href="{{ route('admin.activity-logs.index') }}" class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 transition text-center h-[38px] justify-center">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Kejadian</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">User Pelaku</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aktivitas / Aksi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Entitas Terkait</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat IP</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 font-mono text-sm">
                @forelse ($logs as $log)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3 whitespace-nowrap text-xs">
                            <span class="text-gray-900 font-bold">{{ $log->created_at->format('d/m/Y') }}</span>
                            <span class="text-gray-500 ml-1">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="shrink-0 h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-sans font-bold text-xs uppercase">
                                    {{ substr($log->user->name ?? '?', 0, 1) }}
                                </div>
                                <div class="ml-2 font-sans text-sm font-semibold text-gray-700">
                                    {{ $log->user->name ?? 'System/Deleted' }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-xs">
                            @php
                                $badgeColor = match($log->action) {
                                    'login' => 'bg-blue-100 text-blue-800',
                                    'create' => 'bg-green-100 text-green-800',
                                    'update' => 'bg-yellow-100 text-yellow-800',
                                    'delete' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="px-2 py-0.5 inline-flex font-bold rounded {{ $badgeColor }} border {{ str_replace('bg-', 'border-', str_replace('text-', 'border-', $badgeColor)) }}">
                                {{ strtoupper($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-xs w-1/3">
                            <div class="text-gray-900 line-clamp-2" title="{{ $log->description }}">{{ $log->description }}</div>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center font-sans">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <p class="text-sm font-medium text-gray-900">Belum ada catatan log aktivitas</p>
                                <p class="text-xs text-gray-500 mt-1">Sistem belum mencatat tindakan apa pun, atau filter pencarian Anda terlalu spesifik.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($logs->hasPages())
        <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
            {{ $logs->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

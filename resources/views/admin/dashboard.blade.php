@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
        
        <!-- Total Pendaftar -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full">Total</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['total_pendaftar']) }}</h3>
            <p class="text-sm text-gray-500 font-medium">Pendaftar PPDB Masuk</p>
        </div>

        <!-- Pending (Perlu Verifikasi) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full">Pending</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['pending']) }}</h3>
            <p class="text-sm text-gray-500 font-medium">Menunggu Verifikasi</p>
        </div>

        <!-- Accepted -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-green-100 text-green-700 rounded-full">Lulus</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['accepted']) }}</h3>
            <p class="text-sm text-gray-500 font-medium">Siswa Diterima</p>
        </div>

        <!-- Rejected -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 bg-red-100 text-red-700 rounded-full">Ditolak</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ number_format($stats['rejected']) }}</h3>
            <p class="text-sm text-gray-500 font-medium">Pendaftaran Ditolak</p>
        </div>
    </div>

    <!-- Chart: Grafik Pendaftaran -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-10">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Grafik Pendaftaran PPDB (14 Hari Terakhir)</h2>
            <span class="text-xs font-medium text-gray-400">Jumlah pendaftar per hari</span>
        </div>
        <div class="h-64">
            <canvas id="registrationChart"></canvas>
        </div>
    </div>

    <!-- Second Row (Table + Sidebar) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-10">
        
        <!-- Pendaftar Terbaru -->
        <div class="col-span-1 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                <h2 class="text-lg font-bold text-gray-900">Pendaftar Terakhir</h2>
                <a href="{{ route('admin.ppdb.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">Lihat Semua &rarr;</a>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50/80 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Kode</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Tgl Daftar</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentStudents as $student)
                        <tr class="bg-white border-b border-gray-50 hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900">{{ $student->full_name }}</span>
                                <div class="text-xs text-gray-400 mt-0.5">NIK: {{ $student->nik }}</div>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                {{ $student->registration_code }}
                            </td>
                            <td class="px-6 py-4 text-xs">
                                {{ $student->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-badge :type="$student->status">
                                    {{ $student->status === 'pending' ? 'Pending' : ($student->status === 'accepted' ? 'Diterima' : 'Ditolak') }}
                                </x-badge>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">Belum ada pendaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shortcut & Artikel Stats -->
        <div class="col-span-1 space-y-8">
            
            <!-- System Stats -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                 <h2 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Website Overview</h2>
                 
                 <div class="space-y-4">
                     <div class="flex items-center justify-between">
                         <div class="flex items-center text-gray-600">
                             <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                             Total Artikel
                         </div>
                         <span class="font-bold text-gray-900">{{ number_format($stats['total_posts']) }}</span>
                     </div>
                     <div class="flex items-center justify-between">
                         <div class="flex items-center text-gray-600">
                             <svg class="w-5 h-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                             Artikel Publish
                         </div>
                         <span class="font-bold text-gray-900">{{ number_format($stats['published_posts']) }}</span>
                     </div>
                     <div class="flex items-center justify-between pt-3 border-t">
                         <div class="flex items-center text-gray-600">
                             <svg class="w-5 h-5 mr-3 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                             Pesan Belum Dibaca
                         </div>
                         <span class="font-bold text-red-600">{{ number_format($stats['unread_contacts']) }}</span>
                     </div>
                 </div>
            </div>

            <!-- Recent Articles -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-base font-bold text-gray-900 mb-4 border-b pb-2">Artikel Terakhir</h2>
                <div class="space-y-4">
                    @forelse ($recentPosts as $post)
                        <div>
                            <p class="text-sm font-semibold text-gray-900 truncate"><a href="{{ route('admin.posts.edit', $post) }}" class="hover:text-primary-600">{{ $post->title }}</a></p>
                            <p class="text-xs text-gray-500 mt-1">{{ $post->created_at->format('d M Y') }} &bull; {!! $post->is_published ? '<span class="text-green-600">Published</span>' : '<span class="text-gray-400">Draft</span>' !!}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Belum ada artikel yang diterbitkan.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Activity Log Terbaru -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-900">Aktivitas Terbaru</h2>
            <a href="{{ route('admin.activity-logs.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">Lihat Semua &rarr;</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse ($recentLogs as $log)
                <div class="px-8 py-5 flex items-start gap-5 hover:bg-gray-50/50 transition-colors">
                    <div @class([
                        'shrink-0 w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold',
                        'bg-green-100 text-green-700' => str_contains($log->action, 'create'),
                        'bg-blue-100 text-blue-700' => str_contains($log->action, 'update'),
                        'bg-red-100 text-red-700' => str_contains($log->action, 'delete'),
                        'bg-gray-100 text-gray-700' => !str_contains($log->action, 'create') && !str_contains($log->action, 'update') && !str_contains($log->action, 'delete'),
                    ])>
                        @if(str_contains($log->action, 'create'))
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        @elseif(str_contains($log->action, 'update'))
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        @elseif(str_contains($log->action, 'delete'))
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        @else
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800">{{ $log->description }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            oleh <span class="font-medium text-gray-600">{{ $log->user->name ?? 'System' }}</span>
                            &bull; {{ $log->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="px-8 py-10 text-center text-gray-500 italic">Belum ada aktivitas tercatat.</div>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('registrationChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: @json($chartData['data']),
                backgroundColor: 'rgba(37, 99, 235, 0.15)',
                borderColor: 'rgba(37, 99, 235, 0.8)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(37, 99, 235, 0.3)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        title: (items) => items[0].label,
                        label: (item) => item.raw + ' pendaftar'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 },
                        color: '#9ca3af'
                    },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: {
                        font: { size: 11 },
                        color: '#9ca3af'
                    },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush

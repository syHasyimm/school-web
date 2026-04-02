@extends('layouts.admin')

@section('title', 'Detail Pendaftar: ' . $student->registration_code)

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.ppdb.index') }}" class="p-2 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors text-gray-600">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <h2 class="text-xl font-bold text-gray-900 leading-tight">Detail Registrasi</h2>
    </div>
    <div class="flex flex-wrap gap-2">
        @if(is_array($student->status) || is_object($student->status))
            @php $statusVal = $student->status->value ?? $student->status; @endphp
        @else
            @php $statusVal = $student->status; @endphp
        @endif
        
        @if($statusVal !== 'accepted')
            <form action="{{ route('admin.ppdb.update-status', $student) }}" method="POST" class="inline-block" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="accepted">
                <button type="submit" x-bind:disabled="isSubmitting" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition shadow-sm disabled:opacity-75 disabled:cursor-not-allowed">
                    <svg x-show="!isSubmitting" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    <svg x-show="isSubmitting" x-cloak class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="isSubmitting ? 'Memproses...' : 'Terima Pendaftar'"></span>
                </button>
            </form>
        @endif

        @if($statusVal !== 'rejected')
            <form action="{{ route('admin.ppdb.update-status', $student) }}" method="POST" class="inline-block" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <button type="submit" x-bind:disabled="isSubmitting" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition shadow-sm bg-opacity-90 disabled:opacity-75 disabled:cursor-not-allowed">
                    <svg x-show="!isSubmitting" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    <svg x-show="isSubmitting" x-cloak class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="isSubmitting ? 'Memproses...' : 'Tolak Pendaftar'"></span>
                </button>
            </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Left Column: Data Siswa & Ortu -->
    <div class="xl:col-span-2 space-y-6">
        
        <!-- Header Profil -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden relative">
            <div class="h-24 bg-gradient-to-r from-primary-600 to-indigo-700"></div>
            <div class="px-6 sm:px-8 pb-8 relative -mt-12">
                <div class="flex flex-col sm:flex-row sm:items-end gap-5">
                    <div class="h-24 w-24 rounded-full border-4 border-white bg-white shadow-sm overflow-hidden flex-shrink-0">
                        @php $photoDoc = $student->documents->where('type', 'foto')->first(); @endphp
                        @if($photoDoc)
                            <img src="{{ route('storage.file', $photoDoc->file_path) }}" alt="{{ $student->full_name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-3xl">
                                {{ substr($student->full_name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 pb-1">
                        <div class="flex items-center gap-3">
                            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">{{ $student->full_name }}</h2>
                            @if($statusVal === 'pending')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 border-amber-200 border">Pending</span>
                            @elseif($statusVal === 'accepted')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border-green-200 border">Diterima</span>
                            @elseif($statusVal === 'rejected')
                                <span class="px-2.5 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border-red-200 border">Ditolak</span>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-500 mt-1">NISN: <span class="text-gray-900">{{ $student->nisn }}</span> &bull; Akun Pengguna: <span class="text-primary-600">{{ $student->user->email }}</span></p>
                    </div>
                    
                    @if($statusVal === 'accepted' && $student->verified_at)
                    <div class="text-right pb-1 hidden sm:block">
                        <p class="text-xs text-green-600 font-medium whitespace-nowrap"><svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Telah Diverifikasi Lulus</p>
                        <p class="text-xs text-gray-500 mt-0.5">Oleh {{ $student->verifier->name ?? 'Admin' }}<br>Pada {{ $student->verified_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($statusVal === 'rejected' && $student->rejection_reason)
                <div class="border-t border-red-100 bg-red-50 p-4 px-6 sm:px-8 flex items-start">
                    <svg class="h-5 w-5 text-red-500 mt-0.5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <div>
                        <h4 class="text-sm font-bold text-red-800">Alasan Penolakan</h4>
                        <p class="text-sm text-red-700 mt-1">{{ $student->rejection_reason }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Detail Data -->
        <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden p-6 sm:p-8">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-6">Data Pribadi</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nomor Induk Kependudukan (NIK)</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $student->nik }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">No. Kartu Keluarga (KK)</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $student->no_kk }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $student->birth_place }}, {{ \Carbon\Carbon::parse($student->birth_date)->translatedFormat('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Agama</dt>
                    <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $student->religion }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Asal Sekolah</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $student->previous_school ?? 'Tidak ada / Belum TK' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $student->address }} <br>
                        <span class="text-gray-500 text-xs">RT {{ $student->rt }} / RW {{ $student->rw }}</span>
                    </dd>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-6 mt-10">Data Orang Tua / Wali</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Ibu Kandung</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $student->mother_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nama Ayah (Opsional)</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $student->father_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Pekerjaan Orang Tua</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $student->parent_occupation ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nomor Telepon / HP</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $student->parent_phone }}
                        <a href="https://wa.me/{{ preg_replace('/^08/', '628', $student->parent_phone) }}" target="_blank" class="text-green-600 hover:text-green-800 ml-2 inline-flex items-center text-xs">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.88-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.347-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.876 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg> Hubungi via WA
                        </a>
                    </dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Documents -->
    <div class="xl:col-span-1 space-y-6">
        <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden p-6">
            <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Dokumen Pendaftaran</h3>
            
            <div class="space-y-4">
                @php
                    $documentTypes = [
                        'kk' => 'Kartu Keluarga',
                        'akta_kelahiran' => 'Akta Kelahiran',
                        'ijazah' => 'Ijazah / SKHU',
                    ];
                @endphp
                
                @foreach($documentTypes as $type => $label)
                    @php $doc = $student->documents->where('type', $type)->first(); @endphp
                    <div class="p-4 border border-gray-100 rounded-xl bg-gray-50 flex flex-col justify-between items-start gap-4 transition hover:border-gray-300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center shrink-0">
                                @if($doc)
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $label }}</p>
                                @if($doc)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ number_format($doc->file_size / 1024, 0) }} KB</p>
                                @else
                                    <p class="text-xs text-red-500 mt-0.5">Berkas tidak diunggah</p>
                                @endif
                            </div>
                        </div>
                        
                        @if($doc)
                            <a href="{{ route('storage.file', $doc->file_path) }}" target="_blank" class="w-full inline-flex justify-center items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Lihat Berkas
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 border-t border-gray-100 pt-4">
                <p class="text-xs text-gray-500 text-center flex items-center justify-center">
                    <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Klik Lihat Berkas untuk mengecek kesesuaian data.
                </p>
            </div>
        </div>
        
        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-center shadow-inner">
            <p class="text-sm font-medium text-gray-600 mb-2">Kode Pendaftaran Sistematik:</p>
            <div class="inline-block border-2 border-dashed border-gray-300 px-6 py-3 rounded-xl bg-white text-gray-900 font-mono text-xl font-extrabold tracking-wider">
                {{ $student->registration_code }}
            </div>
        </div>
    </div>
</div>
@endsection

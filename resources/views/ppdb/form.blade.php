@extends('layouts.app')

@section('title', 'Formulir Pendaftaran PPDB - ' . \App\Models\Setting::get('school_name', 'SDN 001 Kepenuhan'))

@section('content')
    <div class="bg-gray-50 min-h-screen pt-8 pb-24 border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 leading-tight">Formulir Registrasi</h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Mendaftar atas nama akun <span class="font-bold text-gray-900">{{ auth()->user()->email }}</span></p>
                </div>
                <div>
                    <a href="{{ route('ppdb.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 flex items-center bg-white border border-gray-200 py-2 px-4 rounded-lg shadow-sm">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Batalkan & Kembali
                    </a>
                </div>
            </div>

            <!-- Pesan Peringatan Waktu Form -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex items-start">
                <svg class="h-6 w-6 text-amber-500 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <div class="text-sm text-amber-800">
                    <p class="font-bold mb-1">Perhatian Penting:</p>
                    <ul class="list-disc ml-4 space-y-1">
                        <li>Mohon siapkan dokumen berformat digital (foto/scan JPG, PNG, PDF maks 2MB).</li>
                        <li>Pastikan koneksi internet stabil saat melakukan upload.</li>
                        <li>Data yang telah *di-submit final* tidak dapat diubah kembali secara mandiri.</li>
                    </ul>
                </div>
            </div>

            <livewire:ppdb.registration-form />

        </div>
    </div>
@endsection

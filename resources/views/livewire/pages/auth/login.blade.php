<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full">
    <div class="mb-8 text-center lg:text-left">
        <h2 class="text-3xl font-extrabold text-gray-900 font-poppins tracking-tight">Selamat Datang!</h2>
        <p class="mt-2 text-sm text-gray-600">Masuk ke akun Anda untuk mengakses portal <span class="font-semibold text-primary-600">Pendaftaran Peserta Didik Baru (PPDB)</span>.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email" class="font-semibold text-gray-700" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white" type="email" name="email" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Kata Sandi" class="font-semibold text-gray-700" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-primary-600 hover:text-primary-500 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500 focus:ring-offset-0">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all hover:-translate-y-0.5 transform">
                Masuk ke Dasbor PPDB
            </button>
        </div>
        
        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun Calon Siswa? 
            <a href="{{ route('register') }}" wire:navigate class="font-semibold text-primary-600 hover:text-primary-500 transition-colors">Daftar sekarang</a>
        </p>
    </form>
</div>

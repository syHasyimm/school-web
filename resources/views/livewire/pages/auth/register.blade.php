<?php

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = UserRole::CalonSiswa;

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('ppdb.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full">
    <div class="mb-6 text-center lg:text-left">
        <h2 class="text-3xl font-extrabold text-gray-900 font-poppins tracking-tight">Buat Akun PPDB</h2>
        <p class="mt-2 text-sm text-gray-600">Pendaftaran akun ini dikhususkan bagi <span class="font-bold text-primary-600">Calon Peserta Didik Baru</span> atau Orang Tua/Wali murid untuk melakukan pengisian formulir PPDB.</p>
    </div>

    <!-- Peringatan -->
    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
        <div class="flex">
            <div class="shrink-0 flex items-center">
                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700">Gunakan email aktif karena status dan pengumuman PPDB akan dikirimkan ke email Anda.</p>
            </div>
        </div>
    </div>

    <form wire:submit="register" class="space-y-4">
        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap (Sesuai KK/Akta)" class="font-semibold text-gray-700" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white" type="text" name="name" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Alamat Email Aktif" class="font-semibold text-gray-700" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white" type="email" name="email" required autocomplete="username" placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Buat Kata Sandi" class="font-semibold text-gray-700" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" class="font-semibold text-gray-700" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500 transition-colors bg-gray-50 focus:bg-white"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all hover:-translate-y-0.5 transform">
                Daftar Akun Calon Siswa
            </button>
        </div>
        
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" wire:navigate class="font-semibold text-primary-600 hover:text-primary-500 transition-colors">Masuk di sini</a>
        </p>
    </form>
</div>

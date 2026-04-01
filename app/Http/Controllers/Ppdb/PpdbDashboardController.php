<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PpdbDashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $student = $user->student()->with('documents')->first();

        return view('ppdb.dashboard', compact('student'));
    }

    public function form(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        // If already registered, redirect to dashboard
        if ($user->student) {
            return redirect()->route('ppdb.dashboard')
                ->with('info', 'Anda sudah terdaftar. Silakan lihat status pendaftaran Anda.');
        }

        return view('ppdb.form');
    }

    public function store()
    {
        // Will be handled by Livewire component
        return redirect()->route('ppdb.dashboard');
    }
}

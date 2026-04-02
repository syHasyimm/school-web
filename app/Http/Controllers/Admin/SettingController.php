<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
        protected ImageService $imageService,
    ) {}

    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'school_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'google_maps_embed' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $this->settingService->set('school_name', $validated['school_name']);
        $this->settingService->set('address', $validated['address']);
        $this->settingService->set('phone', $validated['phone']);
        $this->settingService->set('email', $validated['email']);
        $this->settingService->set('google_maps_embed', $validated['google_maps_embed'] ?? null);

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo_path');
            $this->imageService->delete($oldLogo);
            $path = $this->imageService->upload($request->file('logo'), 'settings', 500);
            $this->settingService->set('logo_path', $path);
        }

        return back()->with('success', 'Pengaturan umum berhasil diperbarui.');
    }

    public function updatePpdb(Request $request)
    {
        $validated = $request->validate([
            'is_ppdb_open' => 'boolean',
            'ppdb_start_date' => 'nullable|date',
            'ppdb_end_date' => 'nullable|date|after_or_equal:ppdb_start_date',
        ]);

        $this->settingService->set('is_ppdb_open', $request->boolean('is_ppdb_open') ? '1' : '0', 'ppdb');
        $this->settingService->set('ppdb_start_date', $validated['ppdb_start_date'] ?? null, 'ppdb');
        $this->settingService->set('ppdb_end_date', $validated['ppdb_end_date'] ?? null, 'ppdb');

        return back()->with('success', 'Pengaturan PPDB berhasil diperbarui.');
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'vision' => 'required|string',
            'mission' => 'required|string',
            'history' => 'required|string',
            'history_photo' => 'nullable|image|max:2048',
            'principal_name' => 'required|string|max:255',
            'principal_photo' => 'nullable|image|max:2048',
            'org_structure' => 'nullable|image|max:4096',
        ]);

        $this->settingService->set('vision', $validated['vision'], 'about');
        $this->settingService->set('mission', $validated['mission'], 'about');
        $this->settingService->set('history', $validated['history'], 'about');
        $this->settingService->set('principal_name', $validated['principal_name'], 'principal');

        if ($request->hasFile('principal_photo')) {
            $oldPhoto = Setting::get('principal_photo');
            $this->imageService->delete($oldPhoto);
            $path = $this->imageService->upload($request->file('principal_photo'), 'settings', 500);
            $this->settingService->set('principal_photo', $path, 'principal');
        }

        if ($request->hasFile('history_photo')) {
            $oldPhoto = Setting::get('history_photo');
            $this->imageService->delete($oldPhoto);
            $path = $this->imageService->upload($request->file('history_photo'), 'settings', 800);
            $this->settingService->set('history_photo', $path, 'about');
        }

        if ($request->hasFile('org_structure')) {
            $oldOrg = Setting::get('org_structure');
            $this->imageService->delete($oldOrg);
            $path = $this->imageService->upload($request->file('org_structure'), 'settings', 1200);
            $this->settingService->set('org_structure', $path, 'about');
        }

        return back()->with('success', 'Informasi Tentang Sekolah berhasil diperbarui.');
    }
}

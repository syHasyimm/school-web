<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Ppdb;
use App\Http\Controllers\Public as PublicControllers;
use Illuminate\Support\Facades\Route;

// File serving route (fallback for Windows/Laragon symlink issues)
Route::get('/berkas/{path}', [FileController::class, 'show'])->where('path', '.*')->name('storage.file');

// ══════════════════════════════════════════════
// PUBLIC ROUTES (Guest accessible)
// ══════════════════════════════════════════════

// Public pages with cache headers (5 min)
Route::middleware(['cache.public'])->group(function () {
    Route::get('/', PublicControllers\HomeController::class)->name('home');
    Route::get('/tentang', PublicControllers\AboutController::class)->name('about');
    Route::get('/guru', \App\Livewire\Public\TeacherList::class)->name('teachers');
    Route::get('/galeri', \App\Livewire\Public\GalleryList::class)->name('gallery');
});

Route::get('/kontak', [PublicControllers\ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [PublicControllers\ContactController::class, 'store'])
    ->middleware('throttle:3,60')
    ->name('contact.store');

Route::get('/berita', \App\Livewire\Public\PostList::class)->name('posts.index');
Route::get('/berita/{slug}', [PublicControllers\PostController::class, 'show'])->name('posts.show');

// Sitemap
Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::published()->get();
    return response()->view('public.sitemap', compact('posts'))
        ->header('Content-Type', 'text/xml');
});

// ══════════════════════════════════════════════
// PPDB ROUTES
// ══════════════════════════════════════════════

Route::get('/ppdb', Ppdb\PpdbInfoController::class)->name('ppdb.info');

Route::middleware(['auth'])->prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/dashboard', [Ppdb\PpdbDashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['ppdb.open', 'throttle:5,1'])->group(function () {
        Route::get('/form', [Ppdb\PpdbDashboardController::class, 'form'])->name('form');
    });

    Route::get('/print', Ppdb\PpdbPrintController::class)->name('print');
});

// ══════════════════════════════════════════════
// AUTH ROUTES (from Breeze)
// ══════════════════════════════════════════════

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on role
        /** @var \App\Models\User $user */
        $user = request()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('ppdb.dashboard');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';

// ══════════════════════════════════════════════
// ADMIN ROUTES
// ══════════════════════════════════════════════

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', Admin\AdminDashboardController::class)->name('dashboard');

    // Posts (Berita)
    Route::resource('posts', Admin\PostController::class);

    // Categories
    Route::resource('categories', Admin\CategoryController::class)->except(['show', 'create', 'edit']);

    // Teachers (Guru)
    Route::resource('teachers', Admin\TeacherController::class)->except(['show']);
    Route::patch('teachers/{teacher}/toggle-active', [Admin\TeacherController::class, 'toggleActive'])
        ->name('teachers.toggle-active');

    // Gallery
    Route::resource('galleries', Admin\GalleryController::class)->except(['show']);
    Route::post('galleries/reorder', [Admin\GalleryController::class, 'reorder'])->name('galleries.reorder');

    // PPDB Management
    Route::get('ppdb', [Admin\PpdbController::class, 'index'])->name('ppdb.index');
    Route::get('ppdb/{student}', [Admin\PpdbController::class, 'show'])->name('ppdb.show');
    Route::patch('ppdb/{student}/status', [Admin\PpdbController::class, 'updateStatus'])->name('ppdb.update-status');
    Route::post('ppdb/bulk-action', [Admin\PpdbController::class, 'bulkAction'])->name('ppdb.bulk-action');
    Route::get('ppdb-export', [Admin\PpdbController::class, 'export'])->name('ppdb.export');

    // Contacts
    Route::get('contacts', [Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::patch('contacts/{contact}/read', [Admin\ContactController::class, 'markAsRead'])->name('contacts.mark-read');

    // Settings
    Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('settings/general', [Admin\SettingController::class, 'updateGeneral'])->name('settings.update-general');
    Route::put('settings/ppdb', [Admin\SettingController::class, 'updatePpdb'])->name('settings.update-ppdb');
    Route::put('settings/about', [Admin\SettingController::class, 'updateAbout'])->name('settings.update-about');

    // Activity Logs
    Route::get('activity-logs', [Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
});

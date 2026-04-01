<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Setting;
use App\Models\Student;
use App\Observers\PostObserver;
use App\Observers\StudentObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register Observers
        Post::observe(PostObserver::class);
        Student::observe(StudentObserver::class);

        // Share global settings with all views
        View::composer('*', function ($view) {
            static $globalSettings = null;

            if ($globalSettings === null) {
                try {
                    $globalSettings = Setting::getMultiple([
                        'school_name',
                        'logo_path',
                        'phone',
                        'email',
                        'address',
                    ]);
                } catch (\Exception $e) {
                    // Handle case where settings table doesn't exist yet (before migration)
                    $globalSettings = [
                        'school_name' => 'SDN 001 Kepenuhan',
                        'logo_path' => null,
                        'phone' => null,
                        'email' => null,
                        'address' => null,
                    ];
                }
            }

            $view->with('globalSettings', $globalSettings);
        });

        // Share unread contacts count with admin layout only
        View::composer('layouts.admin', function ($view) {
            static $unreadCount = null;
            if ($unreadCount === null) {
                try {
                    $unreadCount = \App\Models\Contact::where('is_read', false)->count();
                } catch (\Exception $e) {
                    $unreadCount = 0;
                }
            }
            $view->with('adminUnreadContacts', $unreadCount);
        });
    }
}

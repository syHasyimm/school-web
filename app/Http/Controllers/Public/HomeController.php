<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Setting;

class HomeController extends Controller
{
    public function __invoke()
    {
        $latestPosts = Post::published()
            ->with('author', 'categories')
            ->latest('published_at')
            ->take(3)
            ->get();

        $teacherCount = Teacher::active()->count();
        $studentCount = Student::accepted()->count();
        $isPpdbOpen = Setting::isPpdbOpen();

        $settings = Setting::getMultiple([
            'school_name',
            'principal_name',
            'principal_photo',
            'is_ppdb_open',
        ]);

        return view('public.home', compact(
            'latestPosts', 'teacherCount', 'studentCount', 'isPpdbOpen', 'settings'
        ));
    }
}

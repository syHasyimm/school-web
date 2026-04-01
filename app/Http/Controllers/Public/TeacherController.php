<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function __invoke()
    {
        $teachers = Teacher::active()->ordered()->get();

        return view('public.teachers', compact('teachers'));
    }
}

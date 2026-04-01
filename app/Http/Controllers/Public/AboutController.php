<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class AboutController extends Controller
{
    public function __invoke()
    {
        $settings = Setting::getMultiple([
            'school_name',
            'vision',
            'mission',
            'history',
            'principal_name',
            'principal_photo',
        ]);

        return view('public.about', compact('settings'));
    }
}

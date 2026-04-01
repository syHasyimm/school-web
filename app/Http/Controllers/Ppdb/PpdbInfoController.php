<?php

namespace App\Http\Controllers\Ppdb;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class PpdbInfoController extends Controller
{
    public function __invoke()
    {
        $ppdbInfo = Setting::getMultiple([
            'is_ppdb_open',
            'ppdb_start_date',
            'ppdb_end_date',
            'school_name',
        ]);

        $isPpdbOpen = Setting::isPpdbOpen();

        return view('ppdb.info', compact('ppdbInfo', 'isPpdbOpen'));
    }
}

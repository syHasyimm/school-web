<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = ActivityLog::with('user')
            ->when($request->user_id, fn ($q, $id) => $q->where('user_id', $id))
            ->when($request->action, fn ($q, $a) => $q->where('action', $a))
            ->when($request->date, fn ($q, $d) => $q->whereDate('created_at', $d))
            ->latest('created_at')
            ->paginate(30);

        $actions = ActivityLog::distinct()->pluck('action');

        return view('admin.activity-logs.index', compact('logs', 'actions'));
    }
}

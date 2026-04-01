<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PpdbOpenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Setting::isPpdbOpen()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Pendaftaran PPDB saat ini belum dibuka atau sudah ditutup.',
                ], 403);
            }

            return redirect()->route('ppdb.info')
                ->with('warning', 'Pendaftaran PPDB saat ini belum dibuka atau sudah ditutup.');
        }

        return $next($request);
    }
}

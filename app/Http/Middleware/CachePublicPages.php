<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CachePublicPages
{
    /**
     * Add cache headers to public pages (5 minutes).
     * Skipped for authenticated users to avoid stale personalized content.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only cache GET requests for guests
        if ($request->isMethod('GET') && !$request->user()) {
            $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=300');
        }

        return $response;
    }
}

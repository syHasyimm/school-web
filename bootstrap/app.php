<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CachePublicPages;
use App\Http\Middleware\PpdbOpenMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'ppdb.open' => PpdbOpenMiddleware::class,
            'cache.public' => CachePublicPages::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Log critical errors to dedicated channel
        $exceptions->report(function (\Throwable $e) {
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                return; // Don't log HTTP exceptions (404, 403, etc.)
            }

            Log::channel('single')->critical('CRITICAL ERROR', [
                'message' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
                'url' => request()->fullUrl(),
                'user_id' => auth()->id(),
            ]);
        });
    })->create();


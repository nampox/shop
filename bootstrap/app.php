<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'cms.access' => \App\Http\Middleware\CheckCmsAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle JSON responses for API requests
        $exceptions->render(function (\Throwable $exception, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return \App\Helpers\ResponseHelper::error(
                    app()->environment('production') 
                        ? \App\Constants\Message::SERVER_ERROR 
                        : $exception->getMessage()
                );
            }
            return null; // Let Laravel handle non-JSON requests
        });

        // Log exceptions with context
        $exceptions->report(function (\Throwable $exception) {
            $context = [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];

            if (request()) {
                $context['request'] = [
                    'url' => request()->fullUrl(),
                    'method' => request()->method(),
                    'ip' => request()->ip(),
                ];

                if (auth()->check()) {
                    $context['user'] = [
                        'id' => auth()->id(),
                        'email' => auth()->user()?->email,
                    ];
                }
            }

            if ($exception instanceof \Illuminate\Database\QueryException || 
                $exception instanceof \PDOException) {
                \Log::critical('Critical exception occurred', $context);
            } else {
                \Log::error('Exception occurred', $context);
            }
        });
    })->create();

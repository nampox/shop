<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Constants\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Base controller class for all controllers.
 * 
 * Provides common helper methods for error handling, logging, and responses.
 */
abstract class Controller
{
    /**
     * Handle exception and return appropriate response.
     *
     * @param  \Throwable  $exception
     * @param  \Illuminate\Http\Request|null  $request
     * @param  string  $defaultMessage
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function handleException(
        Throwable $exception,
        $request = null,
        string $defaultMessage = Message::ERROR
    ): JsonResponse|RedirectResponse {
        // Log the exception with context
        $this->logException($exception, $request);

        // Return JSON response for API requests
        if ($request && $request->expectsJson()) {
            return ResponseHelper::error($defaultMessage);
        }

        // Return redirect for web requests
        return ResponseHelper::redirectWithMessage('home', $defaultMessage, 'error');
    }

    /**
     * Log exception with context information.
     *
     * @param  \Throwable  $exception
     * @param  \Illuminate\Http\Request|null  $request
     * @return void
     */
    protected function logException(Throwable $exception, $request = null): void
    {
        $context = [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];

        if ($request) {
            $context['request'] = [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ];

            if (auth()->check()) {
                $context['user'] = [
                    'id' => auth()->id(),
                    'email' => auth()->user()?->email,
                ];
            }
        }

        // Log based on exception severity
        if ($this->isCriticalException($exception)) {
            Log::critical('Critical exception occurred', $context);
        } else {
            Log::error('Exception occurred', $context);
        }
    }

    /**
     * Determine if exception is critical.
     *
     * @param  \Throwable  $exception
     * @return bool
     */
    protected function isCriticalException(Throwable $exception): bool
    {
        $criticalExceptions = [
            \Illuminate\Database\QueryException::class,
            \PDOException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
        ];

        foreach ($criticalExceptions as $criticalException) {
            if ($exception instanceof $criticalException) {
                return true;
            }
        }

        return false;
    }

    /**
     * Log info message with context.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    protected function logInfo(string $message, array $context = []): void
    {
        if (auth()->check()) {
            $context['user_id'] = auth()->id();
        }

        Log::info($message, $context);
    }

    /**
     * Log warning message with context.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    protected function logWarning(string $message, array $context = []): void
    {
        if (auth()->check()) {
            $context['user_id'] = auth()->id();
        }

        Log::warning($message, $context);
    }
}

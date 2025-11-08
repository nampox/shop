<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Constants\HttpStatusCode;
use App\Constants\Message;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCmsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Kiểm tra nếu user có quyền truy cập CMS (role ID 2-9)
        if (!$user->canAccessCms()) {
            // Nếu request là JSON (API), trả về lỗi JSON
            if ($request->expectsJson()) {
                return ResponseHelper::error(
                    Message::FORBIDDEN,
                    null,
                    HttpStatusCode::FORBIDDEN
                );
            }

            // Nếu không phải JSON, redirect về home với thông báo lỗi
            return ResponseHelper::redirectWithMessage(
                'home',
                Message::FORBIDDEN,
                'error'
            );
        }

        return $next($request);
    }
}


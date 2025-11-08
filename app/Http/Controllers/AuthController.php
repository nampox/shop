<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Services\AuthService;
use App\Helpers\ResponseHelper;
use App\Constants\Message;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Hiển thị form đăng ký
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký
     */
    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = $this->authService->register($validated);
            $this->authService->login($user);

            // Log successful registration
            $this->logInfo('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            if ($request->expectsJson()) {
                return ResponseHelper::success(
                    ['user' => $user],
                    Message::REGISTER_SUCCESS
                );
            }

            return ResponseHelper::redirectWithMessage('home', Message::REGISTER_SUCCESS);
        } catch (\Exception $e) {
            return $this->handleException($e, $request, Message::ERROR);
        }
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();
            $remember = $request->boolean('remember');

            if ($this->authService->attemptLogin($credentials, $remember)) {
                $request->session()->regenerate();

                // Log successful login
                $this->logInfo('User logged in successfully', [
                    'user_id' => $this->authService->id(),
                    'email' => $credentials['email'],
                    'ip' => $request->ip(),
                ]);

                if ($request->expectsJson()) {
                    return ResponseHelper::success(
                        ['user' => $this->authService->user()],
                        Message::LOGIN_SUCCESS
                    );
                }

                return ResponseHelper::redirectWithMessage('home', Message::LOGIN_SUCCESS);
            }

            // Log failed login attempt
            $this->logWarning('Failed login attempt', [
                'email' => $credentials['email'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Không tiết lộ email có tồn tại hay không để tránh email enumeration
            if ($request->expectsJson()) {
                return ResponseHelper::error(
                    Message::LOGIN_FAILED,
                    ['email' => [Message::LOGIN_FAILED]]
                );
            }

            throw ValidationException::withMessages([
                'email' => [Message::LOGIN_FAILED],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return $this->handleException($e, $request, Message::ERROR);
        }
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout(Request $request)
    {
        try {
            $userId = $this->authService->id();
            
            $this->authService->logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Log successful logout
            if ($userId) {
                $this->logInfo('User logged out', [
                    'user_id' => $userId,
                    'ip' => $request->ip(),
                ]);
            }

            if ($request->expectsJson()) {
                return ResponseHelper::success(null, Message::LOGOUT_SUCCESS);
            }

            return ResponseHelper::redirectWithMessage('home', Message::LOGOUT_SUCCESS);
        } catch (\Exception $e) {
            return $this->handleException($e, $request, Message::ERROR);
        }
    }
}

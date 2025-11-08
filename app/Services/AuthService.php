<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Constants\Message;

class AuthService
{
    /**
     * Register a new user
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Gán role customer mặc định cho user mới
        $customerRole = Role::where('slug', 'customer')->first();
        if ($customerRole) {
            $user->roles()->attach($customerRole->id);
        }

        return $user->load('roles');
    }

    /**
     * Attempt to login user
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * Login user (after successful authentication)
     *
     * @param User $user
     * @param bool $remember
     * @return void
     */
    public function login(User $user, bool $remember = false): void
    {
        Auth::login($user, $remember);
    }

    /**
     * Logout current user
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Get authenticated user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return Auth::user();
    }

    /**
     * Get authenticated user ID
     *
     * @return int|null
     */
    public function id(): ?int
    {
        return Auth::id();
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * Validate login credentials and throw exception if invalid
     *
     * @param array $credentials
     * @param bool $remember
     * @throws ValidationException
     * @return void
     */
    public function validateLogin(array $credentials, bool $remember = false): void
    {
        if (!$this->attemptLogin($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => [Message::LOGIN_FAILED],
            ]);
        }
    }
}


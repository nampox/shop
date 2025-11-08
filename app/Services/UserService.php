<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * Get paginated users with optional filters
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getUsers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = User::with('roles');

        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Role filter
        if (!empty($filters['role'])) {
            $query->whereHas('roles', function($q) use ($filters) {
                $q->where('slug', $filters['role']);
            });
        }

        // Status filter (verified/unverified)
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($filters['status'] === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Get all active roles
     *
     * @return Collection
     */
    public function getActiveRoles(): Collection
    {
        return Role::where('is_active', true)->get();
    }

    /**
     * Get user statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total' => User::count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
            'unverified' => User::whereNull('email_verified_at')->count(),
            'with_roles' => User::whereHas('roles')->count(),
        ];
    }

    /**
     * Get user by ID with roles
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::with('roles')->find($id);
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @param array|null $roleIds
     * @return User
     */
    public function createUser(array $data, ?array $roleIds = null): User
    {
        $user = User::create($data);

        if ($roleIds) {
            $user->roles()->attach($roleIds);
        }

        return $user->load('roles');
    }

    /**
     * Update user
     *
     * @param int $id
     * @param array $data
     * @return User|null
     */
    public function updateUser(int $id, array $data): ?User
    {
        $user = User::find($id);
        
        if (!$user) {
            return null;
        }

        $user->update($data);
        
        return $user->load('roles');
    }

    /**
     * Update user roles
     *
     * @param int $id
     * @param array $roleIds
     * @return User|null
     */
    public function updateUserRoles(int $id, array $roleIds): ?User
    {
        $user = User::find($id);
        
        if (!$user) {
            return null;
        }

        $user->roles()->sync($roleIds);
        
        return $user->load('roles');
    }

    /**
     * Delete user
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        $user = User::find($id);
        
        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}


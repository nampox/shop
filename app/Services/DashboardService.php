<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Carbon;

class DashboardService
{
    /**
     * Get dashboard statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total_users' => $this->getTotalUsers(),
            'active_users' => $this->getActiveUsers(),
            'recent_users' => $this->getRecentUsers(),
        ];
    }

    /**
     * Get total users count
     *
     * @return int
     */
    public function getTotalUsers(): int
    {
        return User::count();
    }

    /**
     * Get active (verified) users count
     *
     * @return int
     */
    public function getActiveUsers(): int
    {
        return User::whereNotNull('email_verified_at')->count();
    }

    /**
     * Get recent users count (last 7 days)
     *
     * @param int $days
     * @return int
     */
    public function getRecentUsers(int $days = 7): int
    {
        return User::where('created_at', '>=', now()->subDays($days))->count();
    }

    /**
     * Get product statistics
     *
     * @return array
     */
    public function getProductStatistics(): array
    {
        return [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'draft' => Product::where('status', 'draft')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
            'archived' => Product::where('status', 'archived')->count(),
        ];
    }

    /**
     * Get all dashboard statistics (users + products)
     *
     * @return array
     */
    public function getAllStatistics(): array
    {
        return [
            'users' => $this->getStatistics(),
            'products' => $this->getProductStatistics(),
        ];
    }
}


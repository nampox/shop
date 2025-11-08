<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Customer',
                'slug' => 'customer',
                'description' => 'Khách hàng mua sản phẩm',
                'is_active' => true,
            ],
            [
                'name' => 'Seller',
                'slug' => 'seller',
                'description' => 'Người bán hàng',
                'is_active' => true,
            ],
            [
                'name' => 'Seller staff',
                'slug' => 'seller-staff',
                'description' => 'Nhân viên của người bán',
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Quản trị viên hệ thống',
                'is_active' => true,
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'description' => 'Người kiểm duyệt nội dung',
                'is_active' => true,
            ],
            [
                'name' => 'Operations',
                'slug' => 'operations',
                'description' => 'Nhân viên vận hành',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'slug' => 'finance',
                'description' => 'Nhân viên tài chính',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Nhân viên marketing',
                'is_active' => true,
            ],
            [
                'name' => 'CSKH',
                'slug' => 'cskh',
                'description' => 'Chăm sóc khách hàng',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                ...$role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


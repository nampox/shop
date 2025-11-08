<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tìm hoặc tạo user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
                'email_verified_at' => now(),
            ]
        );

        // Tìm role admin
        $adminRole = Role::where('slug', 'admin')->first();

        if ($adminRole) {
            // Gán role admin cho user (syncWithoutDetaching để không xóa các role khác nếu có)
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
            
            $this->command->info('Admin user created successfully with admin role!');
            $this->command->info('Email: admin@gmail.com');
            $this->command->info('Password: admin');
        } else {
            $this->command->error('Admin role not found! Please run RoleSeeder first.');
        }
    }
}


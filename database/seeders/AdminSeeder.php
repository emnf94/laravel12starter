<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'username' => 'admin@admin.com',
            'email' => 'admin@admin.com',
            'role' => UserRole::Admin,
            'password' => Hash::make('admin'),
        ];

        User::create($data);
    }
}

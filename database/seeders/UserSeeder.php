<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@hikegear.test',
            ],
            [
                'name' => 'Admin HikeGear',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'user@hikegear.test',
            ],
            [
                'name' => 'User HikeGear',
                'password' => Hash::make('user12345'),
                'role' => 'user',
            ]
        );
    }
}
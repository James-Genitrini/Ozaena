<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // évite les doublons si tu relances le seeder
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // le mot de passe est "password"
                'is_admin' => true,
            ]
        );
    }
}

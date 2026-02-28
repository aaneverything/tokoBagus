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
            ['email' => 'admin@spp.com'],
            [
                'name' => 'Admin SPP',
                'username' => 'admin',
                'email' => 'admin@spp.com',
                'phone' => '081200000001',
                'roles' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@spp.com'],
            [
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'user@spp.com',
                'phone' => '081200000002',
                'roles' => 'user',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'jane@spp.com'],
            [
                'name' => 'Jane Smith',
                'username' => 'janesmith',
                'email' => 'jane@spp.com',
                'phone' => '081200000003',
                'roles' => 'user',
                'password' => Hash::make('password'),
            ]
        );
    }
}

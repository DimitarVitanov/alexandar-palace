<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@alexandarpalace.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Editor User',
            'email' => 'editor@alexandarpalace.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}

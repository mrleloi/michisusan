<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@example.com';
        $user = User::where('email', $email)->first();

        if (!$user) {
            User::insert([
                [
                    'name' => 'admin',
                    'site_id' => 1,
                    'email' => 'admin@example.com',
                    'password' => Hash::make('password')
                ],
            ]);
        }
    }
}

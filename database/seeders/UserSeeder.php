<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::firstOrCreate(
            ['email' => 'admin@mareddit.com'],
            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'password' => bcrypt('password'),
                'role_id' => 1,
                'badge_id' => 1,
                'email_verified_at' => now(),
            ]
        );

        
        User::firstOrCreate(
            ['email' => 'mod@mareddit.com'],
            [
                'nom' => 'Moderator',
                'prenom' => 'Test',
                'password' => Hash::make('password'),
                'role_id' => 3, 
                'badge_id' => 1, 
                'email_verified_at' => now(),
            ]
        );

        
        User::firstOrCreate(
            ['email' => 'user@mareddit.com'],
            [
                'nom' => 'User',
                'prenom' => 'Test',
                'password' => Hash::make('password'),
                'role_id' => 2, 
                'badge_id' => 1, 
                'email_verified_at' => now(),
            ]
        );

        
        User::factory()->count(20)->create([
            'role_id' => 2, 
            'badge_id' => 1, 
        ]);
    }
}

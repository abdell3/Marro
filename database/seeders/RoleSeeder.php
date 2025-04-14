<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator with full access',
            ],
            [
                'name' => 'Moderator',
                'description' => 'Can moderate content and users',
            ],
            [
                'name' => 'User',
                'description' => 'Regular user',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

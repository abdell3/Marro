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
                'role_name' => 'admin',
                'role_description' => 'Administrateur du site'
            ],
            [
                'role_name' => 'user',
                'role_description' => 'Utilisateur standard'
            ],
            [
                'role_name' => 'moderator',
                'role_description' => 'Modérateur'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

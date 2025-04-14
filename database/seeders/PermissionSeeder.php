<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'manage_users',
                'description' => 'Can manage users',
            ],
            [
                'name' => 'manage_communities',
                'description' => 'Can manage communities',
            ],
            [
                'name' => 'manage_posts',
                'description' => 'Can manage posts',
            ],
            [
                'name' => 'manage_comments',
                'description' => 'Can manage comments',
            ],
            [
                'name' => 'manage_reports',
                'description' => 'Can manage reports',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        
        $adminRole = Role::where('name', 'Admin')->first();
        $moderatorRole = Role::where('name', 'Moderator')->first();

        $adminRole->permissions()->attach(Permission::all());
        $moderatorRole->permissions()->attach(Permission::whereIn(
            'name',
            [
                 'manage_posts',
                 'manage_comments',
                 'manage_reports'
                ])->get()
            );
    }
}

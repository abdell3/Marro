<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Create Posts', 'description' => 'Creation du post'],
            ['name' => 'Edit Posts', 'description' => 'Modification du post'],
            ['name' => 'Delete Posts', 'description' => 'Suppression du post'],
            ['name' => 'Manage Users', 'description' => 'Gérer les utilisateurs'],
            ['name' => 'View Reports', 'description' => 'Voir les reports'],
            ['name' => 'Create reports', 'description' => 'Creation du reports'],
            ['name' => 'Create comment', 'description' => 'Creation du commentaire'],
            ['name' => 'Edit comment', 'description' => 'Modification du commentaire'],
            ['name' => 'Delete comment', 'description' => 'Suppression du commentaire'],
            ['name' => 'Report comment', 'description' => 'Reporter un commentaire'],
            ['name' => 'Manage content', 'description' => 'Gérere les contenus'],
        ];


        foreach ($permissions as $permission) {
            Permission::create($permission);
        }


        $adminRole = Role::create([
            'name' => 'Admin',
            'description' => 'Accès complet'
        ]);


        $moderatorRole = Role::create([
            'name' => 'Moderator',
            'description' => 'Peut modérer le contenu'
        ]);
        
        $userRole = Role::create([
            'name' => 'User',
            'description' => 'Utilisateur'
        ]);



        $adminRole->permissions()->attach(Permission::all());
        $moderatorRole->permissions()->attach(Permission::whereIn('name', [
            'edit-posts', 'delete-posts', 'view-reports',
            'manage-content',
            'view-reports'
        ])->get());
        


        
        $userRole->permissions()->attach(Permission::whereIn('name', [
            'create-post',
            'edit-post',
            'delete-post',
            'create-comment',
            'edit-comment',
            'delete-comment',
            'report-content',
            'create-reports'
        ])->get());

    }
}

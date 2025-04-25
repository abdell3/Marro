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
            
            'create-user',
            'read-user',
            'update-user',
            'delete-user',
            
           
            'create-post',
            'read-post',
            'update-post',
            'delete-post',
            
            
            'create-comment',
            'read-comment',
            'update-comment',
            'delete-comment',
            
           
            'create-community',
            'read-community',
            'update-community',
            'delete-community',
            
            
            'create-report',
            'read-report',
            'handle-report',
            
            
            'moderate-content',
            'ban-user',
            
            
            'manage-roles',
            'manage-permissions'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        
        $adminRole = Role::where('role_name', 'admin')->first();
        $userRole = Role::where('role_name', 'user')->first();
        $moderatorRole = Role::where('role_name', 'moderator')->first();

        
        $adminRole->permissions()->sync(Permission::all());


        $userPermissions = [
            'read-user',
            'create-post',
            'read-post',
            'update-post', 
            'delete-post', 
            'create-comment',
            'read-comment',
            'update-comment', 
            'delete-comment', 
            'read-community',
            'create-report',
            'read-report', 
        ];

        $userRole->permissions()->sync(
            Permission::whereIn('name', $userPermissions)->get()
        );

        
        $moderatorPermissions = [
            'read-user',
            'create-post',
            'read-post',
            'update-post',
            'delete-post',
            'create-comment',
            'read-comment',
            'update-comment',
            'delete-comment',
            'read-community',
            'update-community',
            'create-report',
            'read-report',
            'handle-report',
            'moderate-content',
            'ban-user',
        ];

        $moderatorRole->permissions()->sync(
            Permission::whereIn('name', $moderatorPermissions)->get()
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
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
        
        // $admin = User::create([
        //     'name' => 'Abdellah Abdo',
        //     'username' => 'Abdo',
        //     'email' => 'abdo.abdell.2000@gmail.com',
        //     'password' => Hash::make('Abdo147852369'),
        //     'email_verified_at' => now(),
        // ]);

        
        // $moderator = User::create([
        //     'name' => 'Yassin Akho',
        //     'username' => 'Yc',
        //     'email' => 'yassin.akho@gmail.com',
        //     'password' => Hash::make('0000****0000'),
        //     'email_verified_at' => now(),
        // ]);

        
        // $user = User::create([
        //     'name' => 'Test Testo',
        //     'username' => 'Testoo',
        //     'email' => 'mm3816691@gmail.com',
        //     'password' => Hash::make('Password15963'),
        //     'email_verified_at' => now(),
        // ]);

        
        // $admin->roles()->attach(Role::where('name', 'Admin')->first());
        // $moderator->roles()->attach(Role::where('name', 'Moderator')->first());
        // $user->roles()->attach(Role::where('name', 'User')->first());

        
        // User::factory(10)->create()->each(function ($user) {
        //     $user->roles()->attach(Role::where('name', 'User')->first());
        // });
        
        $roles = Role::all();
        
        User::factory(5)->create()->each(function ($user) use ($roles) {
            // Pick 1 to 3 random roles for each user
            $randomRoles = $roles->random(rand(1, 3))->pluck('id');
            $user->roles()->attach($randomRoles);
        });
        

    }
}

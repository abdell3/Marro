<?php

namespace Database\Seeders;

use App\Http\Controllers\RoleController;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BadgeSeeder::class,
            CommentSeeder::class,
            CommunitySeeder::class,
            PermissionSeeder::class,
            PollOptionSeeder::class,
            PollSeeder::class,
            PostSeeder::class,
            ReportSeeder::class,
            ReportTypeSeeder::class,
            RolePermissionSeeder::class,
            RoleSeeder::class,
            SavedPostSeeder::class,
            ThreadSeeder::class,
            TagSeeder::class,
            UserSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in correct order
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            BadgeSeeder::class,
            ReportTypeSeeder::class,
            UserSeeder::class,
            CommunitySeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            PollSeeder::class,
            SavePostSeeder::class,
            ThreadSeeder::class,
            ReportSeeder::class,
        ]);
    }
}

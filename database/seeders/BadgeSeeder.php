<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Newcomer',
                'description' => 'Joined the community',
                'icon' => 'newcomer.png',
            ],
            [
                'name' => 'Contributor',
                'description' => 'Made 10 posts or comments',
                'icon' => 'contributor.png',
            ],
            [
                'name' => 'Popular',
                'description' => 'Received 100 upvotes',
                'icon' => 'popular.png',
            ],
            [
                'name' => 'Community Builder',
                'description' => 'Created a community with 50+ members',
                'icon' => 'community_builder.png',
            ],
            [
                'name' => 'Verified',
                'description' => 'Verified user',
                'icon' => 'verified.png',
            ],
        ];

        foreach ($badges as $badgeData) {
            Badge::create($badgeData);
        }

        
        $users = User::all();
        $badges = Badge::all();

        foreach ($users as $user) {
            
            $randomBadges = $badges->random(rand(1, 3));
            $user->badges()->attach($randomBadges);
        }
    }
}

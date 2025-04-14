<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communities = [
            [
                'name' => 'Technology',
                'description' => 'Discuss the latest in technology, gadgets, programming, and more.',
                'rules' => "1. Be respectful\n2. No spam\n3. Stay on topic",
                'tags' => ['Technology', 'Science', 'Education'],
            ],
            [
                'name' => 'Gaming',
                'description' => 'A community for gamers to discuss games, share tips, and connect.',
                'rules' => "1. No spoilers without tags\n2. Be respectful\n3. No piracy",
                'tags' => ['Gaming', 'Entertainment'],
            ],
            [
                'name' => 'Sports',
                'description' => 'Discuss sports, teams, players, and events from around the world.',
                'rules' => "1. No personal attacks\n2. Stay on topic\n3. No spam",
                'tags' => ['Sports', 'Fitness', 'Health'],
            ],
            [
                'name' => 'Food',
                'description' => 'Share recipes, cooking tips, restaurant recommendations, and more.',
                'rules' => "1. Be respectful\n2. No spam\n3. Credit sources for recipes",
                'tags' => ['Food', 'Health'],
            ],
            [
                'name' => 'Travel',
                'description' => 'Share travel experiences, tips, and recommendations.',
                'rules' => "1. Be respectful\n2. No spam\n3. Include location information when possible",
                'tags' => ['Travel', 'Photography'],
            ],
        ];

        $users = User::all();

        foreach ($communities as $communityData) {
            $tags = $communityData['tags'];
            
            unset($communityData['tags']);
            
            $community = Community::create([
                'name' => $communityData['name'],
                'slug' => Str::slug($communityData['name']),
                'description' => $communityData['description'],
                'rules' => $communityData['rules'],
            ]);
            
            
            $tagIds = Tag::whereIn('name', $tags)->pluck('id');
            $community->tags()->attach($tagIds);
            
            
            $randomUsers = $users->random(rand(5, 10));
            $community->users()->attach($randomUsers);
        }
    }
}

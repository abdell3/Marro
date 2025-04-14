<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communities = Community::all();
        $users = User::all();
        
        foreach ($communities as $community) {
            
            $communityUsers = $community->users;
            
            
            $postCount = rand(5, 15);
            
            for ($i = 0; $i < $postCount; $i++) {
                $user = $communityUsers->random();
                
                $post = Post::create([
                    'title' => 'Sample Post ' . ($i + 1) . ' in ' . $community->name,
                    'content' => 'This is a sample post content for the ' . $community->name . ' community. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'user_id' => $user->id,
                    'community_id' => $community->id,
                    'upvotes' => rand(0, 100),
                    'downvotes' => rand(0, 20),
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
                
                
                $tagCount = rand(0, 3);
                if ($tagCount > 0) {
                    $communityTags = $community->tags;
                    if ($communityTags->count() > 0) {
                        $randomTags = $communityTags->random(min($tagCount, $communityTags->count()));
                        $post->tags()->attach($randomTags);
                    }
                }
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\Tag;
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
        $users = User::all();
        $communities = Community::all();
        $tags = Tag::all();

        // Create 50 posts
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $community = $communities->random();
            
            // Make sure user is subscribed to this community
            $user->communities()->syncWithoutDetaching([$community->id]);

            $post = Post::create([
                'titre' => "Post #$i dans {$community->theme_name}",
                'contenu' => "Ceci est le contenu du post #$i dans la communauté {$community->theme_name}. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.",
                'typeContenu' => ['text', 'image', 'link', 'video'][rand(0, 3)],
                'datePublication' => now()->subDays(rand(0, 30))->subHours(rand(0, 24)),
                'auteur_id' => $user->id,
                'community_id' => $community->id,
                'like' => rand(-10, 100)
            ]);

            // Attach 1-3 random tags to the post
            $randomTags = $tags->random(rand(1, 3));
            foreach ($randomTags as $tag) {
                $post->tags()->attach($tag->id);
            }
        }
    }
}

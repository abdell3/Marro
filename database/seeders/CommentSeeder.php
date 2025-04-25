<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        // Create 200 comments
        for ($i = 0; $i < 200; $i++) {
            $user = $users->random();
            $post = $posts->random();

            Comment::create([
                'post_id' => $post->id,
                'auteur_id' => $user->id,
                'contenu' => "Ceci est un commentaire sur le post '{$post->titre}'. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.",
                'datePublication' => $post->datePublication->addHours(rand(1, 72))
            ]);
        }
    }
}

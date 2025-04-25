<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        // For each post, add some random votes
        foreach ($posts as $post) {
            // Get random users (between 5 and 15)
            $randomUsers = $users->random(rand(5, 15));

            foreach ($randomUsers as $user) {
                // 70% chance of upvote, 30% chance of downvote
                $voteType = rand(1, 10) <= 7 ? 'upvote' : 'downvote';

                // Make sure the user hasn't already voted on this post
                if (!Poll::where('post_id', $post->id)
                    ->where('utilisateur_id', $user->id)
                    ->exists()) {
                    Poll::create([
                        'utilisateur_id' => $user->id,
                        'post_id' => $post->id,
                        'typeVote' => $voteType
                    ]);
                }
            }
        }
    }
}

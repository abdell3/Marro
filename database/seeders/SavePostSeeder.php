<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\SavePost;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();

        // For each user, save some random posts
        foreach ($users as $user) {
            // Get random posts (between 0 and 10)
            $randomPosts = $posts->random(rand(0, 10));

            foreach ($randomPosts as $post) {
                // Make sure the post isn't already saved by the user
                if (!SavePost::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->exists()) {
                    SavePost::create([
                        'post_id' => $post->id,
                        'user_id' => $user->id
                    ]);
                }
            }
        }
    }
}

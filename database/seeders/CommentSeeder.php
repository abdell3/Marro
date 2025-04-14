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
        $posts = Post::all();
        $users = User::all();
        
        foreach ($posts as $post) {
            
            $commentCount = rand(0, 10);
            
            for ($i = 0; $i < $commentCount; $i++) {
                $user = $users->random();
                
                $comment = Comment::create([
                    'content' => 'This is a sample comment ' . ($i + 1) . ' on this post. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'upvotes' => rand(0, 50),
                    'downvotes' => rand(0, 10),
                    'created_at' => $post->created_at->addHours(rand(1, 24)),
                ]);
                
               
                if (rand(1, 100) <= 30) {
                    
                    $replyCount = rand(1, 3);
                    
                    for ($j = 0; $j < $replyCount; $j++) {
                        $replyUser = $users->random();
                        
                        Comment::create([
                            'content' => 'This is a reply to the comment above. Lorem ipsum dolor sit amet.',
                            'user_id' => $replyUser->id,
                            'post_id' => $post->id,
                            'parent_id' => $comment->id,
                            'upvotes' => rand(0, 20),
                            'downvotes' => rand(0, 5),
                            'created_at' => $comment->created_at->addHours(rand(1, 12)),
                        ]);
                    }
                }
            }
        }
    }
}

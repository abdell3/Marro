<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph, 
            'user_id' => User::factory(), 
            'post_id' => Post::factory(), 
            'parent_id' => null,
        ];
    }
}

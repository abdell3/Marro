<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence, 
            'content' => $this->faker->paragraphs(3, true), 
            'type' => $this->faker->randomElement(['text', 'image', 'video']), 
            'file_path' => $this->faker->imageUrl(), 
            'user_id' => User::factory(), 
            'community_id' => Community::factory(), 
        ];
    }
}

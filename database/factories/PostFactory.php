<?php

namespace Database\Factories;

use App\Models\Community;
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
    public function definition(): array
    {
        $contentTypes = ['text', 'image', 'link', 'video'];
        
        return [
            'titre' => fake()->sentence(rand(5, 10)),
            'contenu' => fake()->paragraphs(rand(1, 5), true),
            'typeContenu' => $contentTypes[array_rand($contentTypes)],
            'datePublication' => fake()->dateTimeBetween('-3 months', 'now'),
            'auteur_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'community_id' => Community::inRandomOrder()->first()->id ?? Community::factory(),
            'like' => rand(-10, 100),
        ];
    }

    /**
     * Indicate that the post is text only.
     */
    public function textOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'typeContenu' => 'text',
        ]);
    }

    /**
     * Indicate that the post is an image.
     */
    public function image(): static
    {
        return $this->state(fn (array $attributes) => [
            'typeContenu' => 'image',
        ]);
    }

    /**
     * Indicate that the post is a link.
     */
    public function link(): static
    {
        return $this->state(fn (array $attributes) => [
            'typeContenu' => 'link',
        ]);
    }

    /**
     * Indicate that the post is a video.
     */
    public function video(): static
    {
        return $this->state(fn (array $attributes) => [
            'typeContenu' => 'video',
        ]);
    }
}

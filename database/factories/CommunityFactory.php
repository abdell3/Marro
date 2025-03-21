<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Community::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word, 
            'slug' => $this->faker->unique()->slug, 
            'description' => $this->faker->paragraph, 
            'user_id' => User::factory(),
        ];
    }
}

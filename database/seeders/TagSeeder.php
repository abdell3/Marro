<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Technology',
            'Science',
            'Gaming',
            'Sports',
            'Politics',
            'News',
            'Entertainment',
            'Art',
            'Music',
            'Food',
            'Travel',
            'Health',
            'Fitness',
            'Fashion',
            'Education',
            'Finance',
            'Business',
            'Humor',
            'Pets',
            'Photography',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}

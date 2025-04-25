<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'title' => 'Discussion',
                'description' => 'Posts qui invitent à la discussion'
            ],
            [
                'title' => 'Question',
                'description' => 'Posts qui posent une question'
            ],
            [
                'title' => 'Aide',
                'description' => 'Posts demandant de l\'aide'
            ],
            [
                'title' => 'Humour',
                'description' => 'Posts humoristiques'
            ],
            [
                'title' => 'Information',
                'description' => 'Posts informatifs'
            ],
            [
                'title' => 'Actualité',
                'description' => 'Posts sur l\'actualité'
            ],
            [
                'title' => 'Critique',
                'description' => 'Posts critiques sur un sujet'
            ],
            [
                'title' => 'Opinion',
                'description' => 'Posts exprimant une opinion'
            ],
            [
                'title' => 'NSFW',
                'description' => 'Contenu sensible, Non Approprié Au Travail'
            ],
            [
                'title' => 'Spoiler',
                'description' => 'Contenu révélant des informations sur une œuvre'
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}

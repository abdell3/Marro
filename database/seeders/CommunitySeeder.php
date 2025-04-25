<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $communities = [
            [
                'theme_name' => 'Technologie',
                'description' => 'Discussion sur les dernières technologies, gadgets et innovations'
            ],
            [
                'theme_name' => 'Gaming',
                'description' => 'Tout ce qui concerne les jeux vidéo, les consoles et le gaming en général'
            ],
            [
                'theme_name' => 'Science',
                'description' => 'Partage de découvertes scientifiques et discussions sur tous les domaines scientifiques'
            ],
            [
                'theme_name' => 'Art',
                'description' => 'Partage et discussion autour de l\'art sous toutes ses formes'
            ],
            [
                'theme_name' => 'Musique',
                'description' => 'Discussions sur la musique, les artistes et les nouveautés'
            ],
            [
                'theme_name' => 'Cinéma',
                'description' => 'Discussions sur les films, séries et l\'industrie cinématographique'
            ],
            [
                'theme_name' => 'Littérature',
                'description' => 'Partage et discussions autour des livres et de la littérature'
            ],
            [
                'theme_name' => 'Sport',
                'description' => 'Discussions sur tous les sports et événements sportifs'
            ],
            [
                'theme_name' => 'Cuisine',
                'description' => 'Partage de recettes et discussions culinaires'
            ],
            [
                'theme_name' => 'Voyage',
                'description' => 'Partage d\'expériences et conseils de voyage'
            ]
        ];

        foreach ($communities as $community) {
            Community::create($community);
        }

        // Subscribe users to communities
        $users = User::all();
        $communities = Community::all();

        foreach ($users as $user) {
            // Subscribe each user to 3-5 random communities
            $randomCommunities = $communities->random(rand(3, 5));
            foreach ($randomCommunities as $community) {
                $user->communities()->syncWithoutDetaching([$community->id]);
            }
        }
    }
}

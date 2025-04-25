<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'nom' => 'Nouveau venu',
                'critere' => 'Inscrit sur le site',
                'logo' => 'badge-nouveau.png'
            ],
            [
                'nom' => 'Contributeur',
                'critere' => 'A créé au moins 10 posts',
                'logo' => 'badge-contributeur.png'
            ],
            [
                'nom' => 'Expert',
                'critere' => 'A obtenu au moins 100 upvotes sur ses posts',
                'logo' => 'badge-expert.png'
            ],
            [
                'nom' => 'Commentateur',
                'critere' => 'A laissé au moins 50 commentaires',
                'logo' => 'badge-commentateur.png'
            ],
            [
                'nom' => 'Populaire',
                'critere' => 'A au moins 500 abonnés à ses communautés',
                'logo' => 'badge-populaire.png'
            ]
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}

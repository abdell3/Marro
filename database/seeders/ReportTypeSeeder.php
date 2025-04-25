<?php

namespace Database\Seeders;

use App\Models\ReportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportTypes = [
            [
                'type' => 'Contenu inapproprié',
                'smallDescription' => 'Contenu qui viole les règles de la communauté'
            ],
            [
                'type' => 'Spam',
                'smallDescription' => 'Contenu répétitif ou publicitaire non sollicité'
            ],
            [
                'type' => 'Harcèlement',
                'smallDescription' => 'Comportement abusif envers un utilisateur'
            ],
            [
                'type' => 'Fausse information',
                'smallDescription' => 'Contenu délibérément trompeur ou faux'
            ],
            [
                'type' => 'Contenu illégal',
                'smallDescription' => 'Contenu qui enfreint la loi'
            ],
            [
                'type' => 'Autre',
                'smallDescription' => 'Autre raison non listée'
            ]
        ];

        foreach ($reportTypes as $reportType) {
            ReportType::create($reportType);
        }
    }
}

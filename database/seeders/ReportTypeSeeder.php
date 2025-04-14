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
                'name' => 'Spam',
                'description' => 'Repeated, unwanted, or unsolicited content',
            ],
            [
                'name' => 'Harassment',
                'description' => 'Threatening, bullying, or intimidating content',
            ],
            [
                'name' => 'Hate Speech',
                'description' => 'Content that promotes hate based on identity or vulnerability',
            ],
            [
                'name' => 'Misinformation',
                'description' => 'False or misleading content presented as fact',
            ],
            [
                'name' => 'Violence',
                'description' => 'Content that encourages, glorifies, or incites violence',
            ],
            [
                'name' => 'Other',
                'description' => 'Other rule violation not listed above',
            ],
        ];

        foreach ($reportTypes as $reportType) {
            ReportType::create($reportType);
        }
    }
}

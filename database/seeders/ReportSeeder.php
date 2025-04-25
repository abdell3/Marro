<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $posts = Post::all();
        $comments = Comment::all();
        $reportTypes = ReportType::all();

        // Create 20 reports for posts
        for ($i = 0; $i < 20; $i++) {
            $user = $users->random();
            $post = $posts->random();
            $reportType = $reportTypes->random();

            // Make sure the user hasn't already reported this post
            if (!Report::where('reportable_type', Post::class)
                ->where('reportable_id', $post->id)
                ->where('utilisateur_id', $user->id)
                ->exists()) {
                Report::create([
                    'reportable_type' => 'App\\Models\\Post',
                    'reportable_id' => $post->id,
                    'utilisateur_id' => $user->id,
                    'date' => now()->subDays(rand(0, 10))->subHours(rand(0, 24)),
                    'raison' => "Raison du signalement: {$reportType->type}",
                    'type_report_id' => $reportType->id
                ]);
            }
        }

        // Create 15 reports for comments
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $comment = $comments->random();
            $reportType = $reportTypes->random();

            // Make sure the user hasn't already reported this comment
            if (!Report::where('reportable_type', Comment::class)
                ->where('reportable_id', $comment->id)
                ->where('utilisateur_id', $user->id)
                ->exists()) {
                Report::create([
                    'reportable_type' => 'App\\Models\\Comment',
                    'reportable_id' => $comment->id,
                    'utilisateur_id' => $user->id,
                    'date' => now()->subDays(rand(0, 10))->subHours(rand(0, 24)),
                    'raison' => "Raison du signalement: {$reportType->type}",
                    'type_report_id' => $reportType->id
                ]);
            }
        }
    }
}

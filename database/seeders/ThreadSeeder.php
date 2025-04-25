<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $communities = Community::all();

        // Create 30 threads
        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $community = $communities->random();
            
            // Make sure user is subscribed to this community
            if (!$user->communities->contains($community->id)) {
                $user->communities()->attach($community->id);
            }

            Thread::create([
                'title' => "Thread #$i dans {$community->theme_name}",
                'content' => "Ceci est le contenu du thread #$i dans la communauté {$community->theme_name}. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                'user_id' => $user->id,
                'community_id' => $community->id
            ]);
        }
    }
}

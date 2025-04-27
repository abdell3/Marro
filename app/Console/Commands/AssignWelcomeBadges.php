<?php

namespace App\Console\Commands;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Console\Command;

class AssignWelcomeBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:assign-welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign welcome badge to all users who don\'t have any badge';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $welcomeBadge = Badge::where('nom', 'Nouveau venu')->first();
        
        if (!$welcomeBadge) {
            $this->error('Welcome badge not found in the database!');
            return Command::FAILURE;
        }
        
        $usersWithoutBadge = User::whereNull('badge_id')->get();
        $count = 0;
        
        foreach ($usersWithoutBadge as $user) {
            $user->badge_id = $welcomeBadge->id;
            $user->save();
            $count++;
        }
        
        $this->info("Successfully assigned welcome badge to {$count} users.");
        
        return Command::SUCCESS;
    }
}

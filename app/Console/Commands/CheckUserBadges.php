<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\Interfaces\BadgeServiceInterface;
use Illuminate\Console\Command;

class CheckUserBadges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:check-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all users and update their badges based on activity';

    /**
     * @var BadgeServiceInterface
     */
    protected $badgeService;

    /**
     * Create a new command instance.
     */
    public function __construct(BadgeServiceInterface $badgeService)
    {
        parent::__construct();
        $this->badgeService = $badgeService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        $updatedCount = 0;
        
        $this->output->progressStart(count($users));
        
        foreach ($users as $user) {
            $newBadges = $this->badgeService->checkAndUpdateBadges($user);
            
            if (count($newBadges) > 0) {
                $updatedCount++;
            }
            
            $this->output->progressAdvance();
        }
        
        $this->output->progressFinish();
        
        $this->info("Updated badges for {$updatedCount} users.");
        
        return Command::SUCCESS;
    }
}

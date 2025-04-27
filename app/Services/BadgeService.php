<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Services\Interfaces\BadgeServiceInterface;

class BadgeService implements BadgeServiceInterface
{
    /**
     * Assign welcome badge to a new user
     * 
     * @param User $user
     * @return bool
     */
    public function assignWelcomeBadge(User $user): bool
    {
        // Get the welcome badge (ID 1 - "Nouveau venu")
        $welcomeBadge = Badge::where('nom', 'Nouveau venu')->first();
        
        if ($welcomeBadge) {
            $user->badge_id = $welcomeBadge->id;
            return $user->save();
        }
        
        return false;
    }
    
    /**
     * Check and update badges for a user
     * 
     * @param User $user
     * @return array
     */
    public function checkAndUpdateBadges(User $user): array
    {
        $newBadges = [];
        $badges = Badge::all();
        
        foreach ($badges as $badge) {
            if ($this->checkQualification($user, $badge->id) && $user->badge_id != $badge->id) {
                $user->badge_id = $badge->id;
                $user->save();
                $newBadges[] = $badge;
            }
        }
        
        return $newBadges;
    }
    
    /**
     * Get all badges available
     * 
     * @return array
     */
    public function getAllBadges(): array
    {
        return Badge::all()->toArray();
    }
    
    /**
     * Check if user qualifies for a specific badge
     * 
     * @param User $user
     * @param int $badgeId
     * @return bool
     */
    public function checkQualification(User $user, int $badgeId): bool
    {
        $badge = Badge::find($badgeId);
        
        if (!$badge) {
            return false;
        }
        
        switch ($badge->nom) {
            case 'Nouveau venu':
                // Always qualify for welcome badge
                return true;
                
            case 'Contributeur':
                // Check if user has at least 10 posts
                return $user->posts->count() >= 10;
                
            case 'Expert':
                // Check if user has at least 100 upvotes on posts
                $totalUpvotes = $user->posts->sum('like');
                return $totalUpvotes >= 100;
                
            case 'Commentateur':
                // Check if user has at least 50 comments
                return $user->comments->count() >= 50;
                
            case 'Populaire':
                // For this example, we'll use a simpler check:
                // Check if user is member of at least 5 communities
                return $user->communities->count() >= 5;
                
            default:
                return false;
        }
    }
}
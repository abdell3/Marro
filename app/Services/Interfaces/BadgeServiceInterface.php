<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface BadgeServiceInterface
{
    /**
     * Assign welcome badge to a new user
     * 
     * @param User $user
     * @return bool
     */
    public function assignWelcomeBadge(User $user): bool;
    
    /**
     * Check and update badges for a user
     * 
     * @param User $user
     * @return array
     */
    public function checkAndUpdateBadges(User $user): array;
    
    /**
     * Get all badges available
     * 
     * @return array
     */
    public function getAllBadges(): array;
    
    /**
     * Check if user qualifies for a specific badge
     * 
     * @param User $user
     * @param int $badgeId
     * @return bool
     */
    public function checkQualification(User $user, int $badgeId): bool;
}
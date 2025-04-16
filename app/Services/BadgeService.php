<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\BadgeRepositoryInterface;

class BadgeService
{
    /**
     * Create a new class instance.
     */
    protected $badgeRepository;

    public function __construct(BadgeRepositoryInterface $badgeRepository)
    {
        $this->badgeRepository = $badgeRepository;
    }

    public function getAllBadges()
    {
        return $this->badgeRepository->all();
    }

    public function getBadgeById($id)
    {
        return $this->badgeRepository->find($id);
    }

    public function getBadgeWithUsers($id)
    {
        return $this->badgeRepository->findWithUsers($id);
    }

    public function getBadgeByName($name)
    {
        return $this->badgeRepository->findByName($name);
    }

    public function createBadge(array $data)
    {
        return $this->badgeRepository->create($data);
    }

    public function updateBadge($id, array $data)
    {
        return $this->badgeRepository->update($id, $data);
    }

    public function deleteBadge($id)
    {
        return $this->badgeRepository->delete($id);
    }

    public function awardBadgeToUser($badgeId, $userId)
    {
        return $this->badgeRepository->attachToUser($badgeId, $userId);
    }

    public function revokeBadgeFromUser($badgeId, $userId)
    {
        return $this->badgeRepository->detachFromUser($badgeId, $userId);
    }

    public function checkAndAwardBadges($userId)
    {
        $user = User::with('posts', 'comments', 'communities')->findOrFail($userId);
        
        
        $this->checkNewcomerBadge($user);
        
        
        $this->checkContributorBadge($user);
        
        
        $this->checkPopularBadge($user);
        
        
        $this->checkCommunityBuilderBadge($user);
    }

    private function checkNewcomerBadge($user)
    {
        $badge = $this->getBadgeByName('Newcomer');
        if ($badge && !$user->badges->contains($badge->id)) {
            $this->awardBadgeToUser($badge->id, $user->id);
        }
    }

    private function checkContributorBadge($user)
    {
        $badge = $this->getBadgeByName('Contributor');
        $contributionCount = $user->posts->count() + $user->comments->count();
        
        if ($badge && $contributionCount >= 10 && !$user->badges->contains($badge->id)) {
            $this->awardBadgeToUser($badge->id, $user->id);
        }
    }

    private function checkPopularBadge($user)
    {
        $badge = $this->getBadgeByName('Popular');
        $totalUpvotes = $user->posts->sum('upvotes') + $user->comments->sum('upvotes');
        
        if ($badge && $totalUpvotes >= 100 && !$user->badges->contains($badge->id)) {
            $this->awardBadgeToUser($badge->id, $user->id);
        }
    }

    private function checkCommunityBuilderBadge($user)
    {
        $badge = $this->getBadgeByName('Community Builder');
        
        foreach ($user->communities as $community) {
            if ($community->users->count() >= 50) {
                if ($badge && !$user->badges->contains($badge->id)) {
                    $this->awardBadgeToUser($badge->id, $user->id);
                    break;
                }
            }
        }
    }
}

<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\Interfaces\BadgeServiceInterface;

class UserBadgeObserver
{
    /**
     * @var BadgeServiceInterface
     */
    protected $badgeService;

    /**
     * UserBadgeObserver constructor.
     * 
     * @param BadgeServiceInterface $badgeService
     */
    public function __construct(BadgeServiceInterface $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        // Check if the user qualifies for new badges after creating a post
        $this->badgeService->checkAndUpdateBadges($post->auteur);
    }

    /**
     * Handle when a post is upvoted
     */
    public function postUpvoted(Post $post): void
    {
        // Check if the author qualifies for new badges after receiving upvotes
        $this->badgeService->checkAndUpdateBadges($post->auteur);
    }

    /**
     * Handle the Comment "created" event.
     */
    public function commentCreated(Comment $comment): void
    {
        // Check if the user qualifies for new badges after creating a comment
        $this->badgeService->checkAndUpdateBadges($comment->auteur);
    }

    /**
     * Handle when a user joins a community
     */
    public function communityJoined(User $user): void
    {
        // Check if the user qualifies for new badges after joining a community
        $this->badgeService->checkAndUpdateBadges($user);
    }
}
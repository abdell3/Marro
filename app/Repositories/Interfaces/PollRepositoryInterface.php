<?php

namespace App\Repositories\Interfaces;

interface PollRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get polls by post
     * @param int $postId
     * @return mixed
     */
    public function getByPost(int $postId);

    /**
     * Get polls by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId);

    /**
     * Count votes by type for a post
     * @param int $postId
     * @param string $type
     * @return int
     */
    public function countVotesByType(int $postId, string $type): int;
}

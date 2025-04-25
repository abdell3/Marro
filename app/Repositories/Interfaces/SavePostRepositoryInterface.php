<?php

namespace App\Repositories\Interfaces;

interface SavePostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get saved posts by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId);

    /**
     * Check if post is saved by user
     * @param int $postId
     * @param int $userId
     * @return bool
     */
    public function isPostSaved(int $postId, int $userId): bool;
}

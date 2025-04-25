<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get comments by post
     * @param int $postId
     * @return mixed
     */
    public function getByPost(int $postId);

    /**
     * Get comments by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId);
}

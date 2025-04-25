<?php

namespace App\Repositories\Interfaces;

interface ReportRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get reports by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId);

    /**
     * Get reports by type
     * @param int $typeId
     * @return mixed
     */
    public function getByType(int $typeId);

    /**
     * Get reports for a post
     * @param int $postId
     * @return mixed
     */
    public function getForPost(int $postId);

    /**
     * Get reports for a comment
     * @param int $commentId
     * @return mixed
     */
    public function getForComment(int $commentId);
}

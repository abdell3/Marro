<?php

namespace App\Repositories\Interfaces;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get posts by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId);

    /**
     * Get posts by community
     * @param int $communityId
     * @return mixed
     */
    public function getByCommunity(int $communityId);

    /**
     * Get posts by tag
     * @param int $tagId
     * @return mixed
     */
    public function getByTag(int $tagId);

    /**
     * Get most popular posts
     * @param int $limit
     * @return mixed
     */
    public function getMostPopular(int $limit = 10);

    /**
     * Add tag to post
     * @param int $postId
     * @param int $tagId
     * @return mixed
     */
    public function addTag(int $postId, int $tagId);

    /**
     * Remove tag from post
     * @param int $postId
     * @param int $tagId
     * @return mixed
     */
    public function removeTag(int $postId, int $tagId);

    /**
     * Update post likes count
     * @param int $postId
     * @param int $delta
     * @return mixed
     */
    public function updateLikes(int $postId, int $delta);
}

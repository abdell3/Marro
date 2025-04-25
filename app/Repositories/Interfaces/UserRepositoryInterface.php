<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find user by email
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Get users by role
     * @param int $roleId
     * @return mixed
     */
    public function getUsersByRole(int $roleId);

    /**
     * Add community to user
     * @param int $userId
     * @param int $communityId
     * @return mixed
     */
    public function addCommunity(int $userId, int $communityId);

    /**
     * Remove community from user
     * @param int $userId
     * @param int $communityId
     * @return mixed
     */
    public function removeCommunity(int $userId, int $communityId);

    /**
     * Save post for user
     * @param int $userId
     * @param int $postId
     * @return mixed
     */
    public function savePost(int $userId, int $postId);

    /**
     * Unsave post for user
     * @param int $userId
     * @param int $postId
     * @return mixed
     */
    public function unsavePost(int $userId, int $postId);
}

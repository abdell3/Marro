<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Find user by email
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Get users by role
     * @param int $roleId
     * @return mixed
     */
    public function getUsersByRole(int $roleId)
    {
        return $this->model->where('role_id', $roleId)->get();
    }

    /**
     * Add community to user
     * @param int $userId
     * @param int $communityId
     * @return mixed
     */
    public function addCommunity(int $userId, int $communityId)
    {
        $user = $this->find($userId);
        return $user->communities()->attach($communityId);
    }

    /**
     * Remove community from user
     * @param int $userId
     * @param int $communityId
     * @return mixed
     */
    public function removeCommunity(int $userId, int $communityId)
    {
        $user = $this->find($userId);
        return $user->communities()->detach($communityId);
    }

    /**
     * Save post for user
     * @param int $userId
     * @param int $postId
     * @return mixed
     */
    public function savePost(int $userId, int $postId)
    {
        $user = $this->find($userId);
        return $user->savedPosts()->attach($postId);
    }

    /**
     * Unsave post for user
     * @param int $userId
     * @param int $postId
     * @return mixed
     */
    public function unsavePost(int $userId, int $postId)
    {
        $user = $this->find($userId);
        return $user->savedPosts()->detach($postId);
    }
}

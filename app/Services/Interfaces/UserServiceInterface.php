<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /**
     * Get all users
     * @return Collection
     */
    public function getAllUsers(): Collection;
    
    /**
     * Get user by ID
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User;
    
    /**
     * Create new user
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User;
    
    /**
     * Update user
     * @param int $id
     * @param array $data
     * @return User
     */
    public function updateUser(int $id, array $data): User;
    
    /**
     * Delete user
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool;
    
    /**
     * Get user by email
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User;
    
    /**
     * Register new user
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User;
    
    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return array
     */
    public function loginUser(string $email, string $password): array;
    
    /**
     * Logout user
     * @param int $id
     * @return bool
     */
    public function logoutUser(int $id): bool;
    
    /**
     * Subscribe user to community
     * @param int $userId
     * @param int $communityId
     * @return bool
     */
    public function subscribeToCommunity(int $userId, int $communityId): bool;
    
    /**
     * Unsubscribe user from community
     * @param int $userId
     * @param int $communityId
     * @return bool
     */
    public function unsubscribeFromCommunity(int $userId, int $communityId): bool;
    
    /**
     * Save post for user
     * @param int $userId
     * @param int $postId
     * @return bool
     */
    public function savePost(int $userId, int $postId): bool;
    
    /**
     * Unsave post for user
     * @param int $userId
     * @param int $postId
     * @return bool
     */
    public function unsavePost(int $userId, int $postId): bool;
    
    /**
     * Get user's saved posts
     * @param int $userId
     * @return Collection
     */
    public function getSavedPosts(int $userId): Collection;
    
    /**
     * Check if user has permission
     * @param int $userId
     * @param string $permission
     * @return bool
     */
    public function hasPermission(int $userId, string $permission): bool;
    
    /**
     * Check if user has role
     * @param int $userId
     * @param string $roleName
     * @return bool
     */
    public function hasRole(int $userId, string $roleName): bool;
}

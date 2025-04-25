<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\SavePostRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var SavePostRepositoryInterface
     */
    protected $savePostRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param SavePostRepositoryInterface $savePostRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        SavePostRepositoryInterface $savePostRepository
    ) {
        $this->userRepository = $userRepository;
        $this->savePostRepository = $savePostRepository;
    }

    /**
     * Get all users
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return collect($this->userRepository->all());
    }

    /**
     * Get user by ID
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User
    {
        return $this->userRepository->find($id);
    }

    /**
     * Create new user
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->create($data);
    }

    /**
     * Update user
     * @param int $id
     * @param array $data
     * @return User
     */
    public function updateUser(int $id, array $data): User
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($id, $data);
    }

    /**
     * Delete user
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Get user by email
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Register new user
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        // Assign default role (regular user)
        if (!isset($data['role_id'])) {
            $data['role_id'] = 2; // Assuming 2 is the ID for regular users
        }

        // Set token for email verification
        $data['token'] = bin2hex(random_bytes(32));

        return $this->createUser($data);
    }

    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return array
     */
    public function loginUser(string $email, string $password): array
    {
        $user = $this->getUserByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'user' => null
            ];
        }

        return [
            'success' => true,
            'message' => 'Login successful',
            'user' => $user
        ];
    }

    /**
     * Logout user
     * @param int $id
     * @return bool
     */
    public function logoutUser(int $id): bool
    {
        // In a custom auth implementation, we might need to invalidate tokens or sessions
        // For simplicity, this method returns true
        return true;
    }

    /**
     * Subscribe user to community
     * @param int $userId
     * @param int $communityId
     * @return bool
     */
    public function subscribeToCommunity(int $userId, int $communityId): bool
    {
        $this->userRepository->addCommunity($userId, $communityId);
        return true;
    }

    /**
     * Unsubscribe user from community
     * @param int $userId
     * @param int $communityId
     * @return bool
     */
    public function unsubscribeFromCommunity(int $userId, int $communityId): bool
    {
        $this->userRepository->removeCommunity($userId, $communityId);
        return true;
    }

    /**
     * Save post for user
     * @param int $userId
     * @param int $postId
     * @return bool
     */
    public function savePost(int $userId, int $postId): bool
    {
        // Check if post is already saved
        if ($this->savePostRepository->isPostSaved($postId, $userId)) {
            return false;
        }

        $this->userRepository->savePost($userId, $postId);
        return true;
    }

    /**
     * Unsave post for user
     * @param int $userId
     * @param int $postId
     * @return bool
     */
    public function unsavePost(int $userId, int $postId): bool
    {
        $this->userRepository->unsavePost($userId, $postId);
        return true;
    }

    /**
     * Get user's saved posts
     * @param int $userId
     * @return Collection
     */
    public function getSavedPosts(int $userId): Collection
    {
        $user = $this->getUserById($userId);
        return collect($user->savedPosts);
    }

    /**
     * Check if user has permission
     * @param int $userId
     * @param string $permission
     * @return bool
     */
    public function hasPermission(int $userId, string $permission): bool
    {
        $user = $this->getUserById($userId);
        return $user->hasPermission($permission);
    }

    /**
     * Check if user has role
     * @param int $userId
     * @param string $roleName
     * @return bool
     */
    public function hasRole(int $userId, string $roleName): bool
    {
        $user = $this->getUserById($userId);
        return $user->hasRole($roleName);
    }
}

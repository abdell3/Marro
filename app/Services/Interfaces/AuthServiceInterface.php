<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface AuthServiceInterface
{
    /**
     * Register user
     * @param array $data
     * @return User
     */
    public function register(array $data): User;
    
    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login(string $email, string $password): array;
    
    /**
     * Logout user
     * @return bool
     */
    public function logout(): bool;
    
    /**
     * Get authenticated user
     * @return User|null
     */
    public function user(): ?User;
    
    /**
     * Verify user email
     * @param string $token
     * @return bool
     */
    public function verifyEmail(string $token): bool;
    
    /**
     * Send password reset link
     * @param string $email
     * @return bool
     */
    public function sendPasswordResetLink(string $email): bool;
    
    /**
     * Reset password
     * @param array $data
     * @return bool
     */
    public function resetPassword(array $data): bool;
}

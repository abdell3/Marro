<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * AuthService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register user
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        // Hash password
        $data['password'] = Hash::make($data['password']);
        
        // Assign default role (regular user)
        if (!isset($data['role_id'])) {
            $data['role_id'] = 2; // Assuming 2 is the ID for regular users
        }
        
        // Generate verification token
        $data['token'] = bin2hex(random_bytes(32));
        
        // Create user
        $user = $this->userRepository->create($data);
        
        // Login the user
        Auth::login($user);
        
        return $user;
    }

    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail($email);
        
        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'user' => null
            ];
        }
        
        // Login user using Laravel's authentication
        Auth::login($user);
        
        return [
            'success' => true,
            'message' => 'Login successful',
            'user' => $user
        ];
    }

    /**
     * Logout user
     * @return bool
     */
    public function logout(): bool
    {
        Auth::logout();
        return true;
    }

    /**
     * Get authenticated user
     * @return User|null
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Verify user email
     * @param string $token
     * @return bool
     */
    public function verifyEmail(string $token): bool
    {
        $user = $this->userRepository->firstWhere(['token' => $token]);
        
        if (!$user) {
            return false;
        }
        
        // Verify email
        $this->userRepository->update($user->id, [
            'email_verified_at' => now(),
            'token' => null
        ]);
        
        return true;
    }

    /**
     * Send password reset link
     * @param string $email
     * @return bool
     */
    public function sendPasswordResetLink(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        
        if (!$user) {
            return false;
        }
        
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        
        // Update user token
        $this->userRepository->update($user->id, [
            'token' => $token
        ]);
        
        // In a real application, we would send an email with the reset link
        // For this example, we'll just return true
        
        return true;
    }

    /**
     * Reset password
     * @param array $data
     * @return bool
     */
    public function resetPassword(array $data): bool
    {
        $user = $this->userRepository->firstWhere(['token' => $data['token']]);
        
        if (!$user) {
            return false;
        }
        
        // Update password and clear token
        $this->userRepository->update($user->id, [
            'password' => Hash::make($data['password']),
            'token' => null
        ]);
        
        return true;
    }
}
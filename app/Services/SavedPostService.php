<?php

namespace App\Services;

use App\Repositories\Interfaces\SavedPostRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class SavedPostService
{
    /**
     * Create a new class instance.
     */
    protected $savedPostRepository;

    public function __construct(SavedPostRepositoryInterface $savedPostRepository)
    {
        $this->savedPostRepository = $savedPostRepository;
    }

    public function getSavedPostsByUser($userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $this->savedPostRepository->findByUser($userId);
    }

    public function savePost($postId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        
        $existingSave = $this->savedPostRepository->findByUserAndPost($userId, $postId);
        
        if (!$existingSave) {
            return $this->savedPostRepository->create([
                'user_id' => $userId,
                'post_id' => $postId
            ]);
        }
        
        return $existingSave;
    }

    public function unsavePost($postId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        $savedPost = $this->savedPostRepository->findByUserAndPost($userId, $postId);
        
        if ($savedPost) {
            return $this->savedPostRepository->delete($savedPost->id);
        }
        
        return false;
    }

    public function isPostSavedByUser($postId, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $this->savedPostRepository->findByUserAndPost($userId, $postId) !== null;
    }
}

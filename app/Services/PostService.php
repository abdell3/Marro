<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Interfaces\PollRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Support\Collection;

class PostService implements PostServiceInterface
{
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;
    
    /**
     * @var PollRepositoryInterface
     */
    protected $pollRepository;
    
    /**
     * @var ReportRepositoryInterface
     */
    protected $reportRepository;

    /**
     * PostService constructor.
     * @param PostRepositoryInterface $postRepository
     * @param PollRepositoryInterface $pollRepository
     * @param ReportRepositoryInterface $reportRepository
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        PollRepositoryInterface $pollRepository,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->postRepository = $postRepository;
        $this->pollRepository = $pollRepository;
        $this->reportRepository = $reportRepository;
    }

    /**
     * Get all posts
     * @return Collection
     */
    public function getAllPosts(): Collection
    {
        return collect($this->postRepository->all());
    }

    /**
     * Get post by ID
     * @param int $id
     * @return Post
     */
    public function getPostById(int $id): Post
    {
        return $this->postRepository->find($id);
    }

    /**
     * Create new post
     * @param array $data
     * @return Post
     */
    public function createPost(array $data): Post
    {
        // Set default values if not provided
        if (!isset($data['datePublication'])) {
            $data['datePublication'] = now();
        }
        
        if (!isset($data['like'])) {
            $data['like'] = 0;
        }
        
        return $this->postRepository->create($data);
    }

    /**
     * Update post
     * @param int $id
     * @param array $data
     * @return Post
     */
    public function updatePost(int $id, array $data): Post
    {
        return $this->postRepository->update($id, $data);
    }

    /**
     * Delete post
     * @param int $id
     * @return bool
     */
    public function deletePost(int $id): bool
    {
        return $this->postRepository->delete($id);
    }

    /**
     * Get posts by user
     * @param int $userId
     * @return Collection
     */
    public function getPostsByUser(int $userId): Collection
    {
        return collect($this->postRepository->getByUser($userId));
    }

    /**
     * Get posts by community
     * @param int $communityId
     * @return Collection
     */
    public function getPostsByCommunity(int $communityId): Collection
    {
        return collect($this->postRepository->getByCommunity($communityId));
    }

    /**
     * Get most popular posts
     * @param int $limit
     * @return Collection
     */
    public function getMostPopularPosts(int $limit = 10): Collection
    {
        return collect($this->postRepository->getMostPopular($limit));
    }

    /**
     * Vote on post
     * @param int $postId
     * @param int $userId
     * @param string $voteType
     * @return bool
     */
    public function voteOnPost(int $postId, int $userId, string $voteType): bool
    {
        // Check if user already voted
        $existingVote = $this->pollRepository->firstWhere([
            'post_id' => $postId,
            'utilisateur_id' => $userId
        ]);
        
        if ($existingVote) {
            // Update vote if type has changed
            if ($existingVote->typeVote !== $voteType) {
                // If changing from downvote to upvote, increment by 2
                // If changing from upvote to downvote, decrement by 2
                $delta = $voteType === 'upvote' ? 2 : -2;
                
                $this->pollRepository->update($existingVote->id, [
                    'typeVote' => $voteType
                ]);
                
                $this->postRepository->updateLikes($postId, $delta);
            }
            
            return true;
        }
        
        // Create new vote
        $this->pollRepository->create([
            'post_id' => $postId,
            'utilisateur_id' => $userId,
            'typeVote' => $voteType
        ]);
        
        // Update post like count
        $delta = $voteType === 'upvote' ? 1 : -1;
        $this->postRepository->updateLikes($postId, $delta);
        
        return true;
    }

    /**
     * Add tag to post
     * @param int $postId
     * @param int $tagId
     * @return bool
     */
    public function addTagToPost(int $postId, int $tagId): bool
    {
        $this->postRepository->addTag($postId, $tagId);
        return true;
    }

    /**
     * Remove tag from post
     * @param int $postId
     * @param int $tagId
     * @return bool
     */
    public function removeTagFromPost(int $postId, int $tagId): bool
    {
        $this->postRepository->removeTag($postId, $tagId);
        return true;
    }

    /**
     * Report post
     * @param int $postId
     * @param int $userId
     * @param string $reason
     * @param int $reportTypeId
     * @return bool
     */
    public function reportPost(int $postId, int $userId, string $reason, int $reportTypeId): bool
    {
        $this->reportRepository->create([
            'reportable_type' => 'App\\Models\\Post',
            'reportable_id' => $postId,
            'utilisateur_id' => $userId,
            'date' => now(),
            'raison' => $reason,
            'type_report_id' => $reportTypeId
        ]);
        
        return true;
    }
}

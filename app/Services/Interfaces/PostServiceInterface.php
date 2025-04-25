<?php

namespace App\Services\Interfaces;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostServiceInterface
{
    /**
     * Get all posts
     * @return Collection
     */
    public function getAllPosts(): Collection;
    
    /**
     * Get post by ID
     * @param int $id
     * @return Post
     */
    public function getPostById(int $id): Post;
    
    /**
     * Create new post
     * @param array $data
     * @return Post
     */
    public function createPost(array $data): Post;
    
    /**
     * Update post
     * @param int $id
     * @param array $data
     * @return Post
     */
    public function updatePost(int $id, array $data): Post;
    
    /**
     * Delete post
     * @param int $id
     * @return bool
     */
    public function deletePost(int $id): bool;
    
    /**
     * Get posts by user
     * @param int $userId
     * @return Collection
     */
    public function getPostsByUser(int $userId): Collection;
    
    /**
     * Get posts by community
     * @param int $communityId
     * @return Collection
     */
    public function getPostsByCommunity(int $communityId): Collection;
    
    /**
     * Get most popular posts
     * @param int $limit
     * @return Collection
     */
    public function getMostPopularPosts(int $limit = 10): Collection;
    
    /**
     * Vote on post
     * @param int $postId
     * @param int $userId
     * @param string $voteType
     * @return bool
     */
    public function voteOnPost(int $postId, int $userId, string $voteType): bool;
    
    /**
     * Add tag to post
     * @param int $postId
     * @param int $tagId
     * @return bool
     */
    public function addTagToPost(int $postId, int $tagId): bool;
    
    /**
     * Remove tag from post
     * @param int $postId
     * @param int $tagId
     * @return bool
     */
    public function removeTagFromPost(int $postId, int $tagId): bool;
    
    /**
     * Report post
     * @param int $postId
     * @param int $userId
     * @param string $reason
     * @param int $reportTypeId
     * @return bool
     */
    public function reportPost(int $postId, int $userId, string $reason, int $reportTypeId): bool;
}

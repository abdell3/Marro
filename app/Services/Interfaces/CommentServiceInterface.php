<?php

namespace App\Services\Interfaces;

use App\Models\Comment;
use Illuminate\Support\Collection;

interface CommentServiceInterface
{
    /**
     * Get all comments
     * @return Collection
     */
    public function getAllComments(): Collection;
    
    /**
     * Get comment by ID
     * @param int $id
     * @return Comment
     */
    public function getCommentById(int $id): Comment;
    
    /**
     * Create new comment
     * @param array $data
     * @return Comment
     */
    public function createComment(array $data): Comment;
    
    /**
     * Update comment
     * @param int $id
     * @param array $data
     * @return Comment
     */
    public function updateComment(int $id, array $data): Comment;
    
    /**
     * Delete comment
     * @param int $id
     * @return bool
     */
    public function deleteComment(int $id): bool;
    
    /**
     * Get comments by post
     * @param int $postId
     * @return Collection
     */
    public function getCommentsByPost(int $postId): Collection;
    
    /**
     * Get comments by user
     * @param int $userId
     * @return Collection
     */
    public function getCommentsByUser(int $userId): Collection;
    
    /**
     * Report comment
     * @param int $commentId
     * @param int $userId
     * @param string $reason
     * @param int $reportTypeId
     * @return bool
     */
    public function reportComment(int $commentId, int $userId, string $reason, int $reportTypeId): bool;
}

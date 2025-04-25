<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Support\Collection;

class CommentService implements CommentServiceInterface
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;
    
    /**
     * @var ReportRepositoryInterface
     */
    protected $reportRepository;

    /**
     * CommentService constructor.
     * @param CommentRepositoryInterface $commentRepository
     * @param ReportRepositoryInterface $reportRepository
     */
    public function __construct(
        CommentRepositoryInterface $commentRepository,
        ReportRepositoryInterface $reportRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->reportRepository = $reportRepository;
    }

    /**
     * Get all comments
     * @return Collection
     */
    public function getAllComments(): Collection
    {
        return collect($this->commentRepository->all());
    }

    /**
     * Get comment by ID
     * @param int $id
     * @return Comment
     */
    public function getCommentById(int $id): Comment
    {
        return $this->commentRepository->find($id);
    }

    /**
     * Create new comment
     * @param array $data
     * @return Comment
     */
    public function createComment(array $data): Comment
    {
        // Set default values if not provided
        if (!isset($data['datePublication'])) {
            $data['datePublication'] = now();
        }
        
        return $this->commentRepository->create($data);
    }

    /**
     * Update comment
     * @param int $id
     * @param array $data
     * @return Comment
     */
    public function updateComment(int $id, array $data): Comment
    {
        return $this->commentRepository->update($id, $data);
    }

    /**
     * Delete comment
     * @param int $id
     * @return bool
     */
    public function deleteComment(int $id): bool
    {
        return $this->commentRepository->delete($id);
    }

    /**
     * Get comments by post
     * @param int $postId
     * @return Collection
     */
    public function getCommentsByPost(int $postId): Collection
    {
        return collect($this->commentRepository->getByPost($postId));
    }

    /**
     * Get comments by user
     * @param int $userId
     * @return Collection
     */
    public function getCommentsByUser(int $userId): Collection
    {
        return collect($this->commentRepository->getByUser($userId));
    }

    /**
     * Report comment
     * @param int $commentId
     * @param int $userId
     * @param string $reason
     * @param int $reportTypeId
     * @return bool
     */
    public function reportComment(int $commentId, int $userId, string $reason, int $reportTypeId): bool
    {
        $this->reportRepository->create([
            'reportable_type' => 'App\\Models\\Comment',
            'reportable_id' => $commentId,
            'utilisateur_id' => $userId,
            'date' => now(),
            'raison' => $reason,
            'type_report_id' => $reportTypeId
        ]);
        
        return true;
    }
}

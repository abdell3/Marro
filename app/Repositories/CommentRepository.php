<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository constructor.
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get comments by post
     * @param int $postId
     * @return mixed
     */
    public function getByPost(int $postId)
    {
        return $this->model->where('post_id', $postId)
            ->whereNull('parent_id')
            ->with(['auteur', 'replies.auteur'])
            ->orderBy('datePublication', 'desc')
            ->get();
    }

    /**
     * Get comments by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('auteur_id', $userId)->get();
    }
}

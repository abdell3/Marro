<?php

namespace App\Repositories;

use App\Models\SavedPost;
use App\Repositories\Interfaces\SavedPostRepositoryInterface;

class SavedPostRepository extends BaseRepository implements SavedPostRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(SavedPost $model)
    {
        parent::__construct($model);
    }

    public function findByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function findByUserAndPost($userId, $postId)
    {
        return $this->model->where('user_id', $userId)
            ->where('post_id', $postId)
            ->first();
    }
}

<?php

namespace App\Repositories;

use App\Models\SavePost;
use App\Repositories\Interfaces\SavePostRepositoryInterface;

class SavePostRepository extends BaseRepository implements SavePostRepositoryInterface
{
    /**
     * SavePostRepository constructor.
     * @param SavePost $model
     */
    public function __construct(SavePost $model)
    {
        parent::__construct($model);
    }

    /**
     * Get saved posts by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * Check if post is saved by user
     * @param int $postId
     * @param int $userId
     * @return bool
     */
    public function isPostSaved(int $postId, int $userId): bool
    {
        return $this->model->where('post_id', $postId)
            ->where('user_id', $userId)
            ->exists();
    }
}

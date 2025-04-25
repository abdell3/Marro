<?php

namespace App\Repositories;

use App\Models\Thread;
use App\Repositories\Interfaces\ThreadRepositoryInterface;

class ThreadRepository extends BaseRepository implements ThreadRepositoryInterface
{
    /**
     * ThreadRepository constructor.
     * @param Thread $model
     */
    public function __construct(Thread $model)
    {
        parent::__construct($model);
    }

    /**
     * Get threads by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * Get threads by community
     * @param int $communityId
     * @return mixed
     */
    public function getByCommunity(int $communityId)
    {
        return $this->model->where('community_id', $communityId)->get();
    }
}

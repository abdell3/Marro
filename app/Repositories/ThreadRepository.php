<?php

namespace App\Repositories;

use App\Models\Thread;
use App\Repositories\Interfaces\ThreadRepositoryInterface;

class ThreadRepository extends BaseRepository implements ThreadRepositoryInterface
{
    public function __construct(Thread $model)
    {
        parent::__construct($model);
    }

    public function findByCommunity($communityId)
    {
        return $this->model->where('community_id', $communityId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}

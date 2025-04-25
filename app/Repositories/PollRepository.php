<?php

namespace App\Repositories;

use App\Models\Poll;
use App\Repositories\Interfaces\PollRepositoryInterface;

class PollRepository extends BaseRepository implements PollRepositoryInterface
{
    /**
     * PollRepository constructor.
     * @param Poll $model
     */
    public function __construct(Poll $model)
    {
        parent::__construct($model);
    }

    /**
     * Get polls by post
     * @param int $postId
     * @return mixed
     */
    public function getByPost(int $postId)
    {
        return $this->model->where('post_id', $postId)->get();
    }

    /**
     * Get polls by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('utilisateur_id', $userId)->get();
    }

    /**
     * Count votes by type for a post
     * @param int $postId
     * @param string $type
     * @return int
     */
    public function countVotesByType(int $postId, string $type): int
    {
        return $this->model->where('post_id', $postId)
            ->where('typeVote', $type)
            ->count();
    }
}

<?php

namespace App\Repositories;

use App\Models\Badge;
use App\Repositories\Interfaces\BadgeRepositoryInterface;

class BadgeRepository extends BaseRepository implements BadgeRepositoryInterface
{
    /**
     * BadgeRepository constructor.
     * @param Badge $model
     */
    public function __construct(Badge $model)
    {
        parent::__construct($model);
    }

    /**
     * Find badge by name
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->model->where('nom', $name)->first();
    }

    /**
     * Get users with badge
     * @param int $badgeId
     * @return mixed
     */
    public function getUsersWithBadge(int $badgeId)
    {
        $badge = $this->find($badgeId);
        return $badge->users;
    }
}

<?php

namespace App\Repositories;

use App\Models\Badge;
use App\Repositories\Interfaces\BadgeRepositoryInterface;

class BadgeTypeRepository extends BaseRepository implements BadgeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Badge $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function findWithUsers($id)
    {
        return $this->model->with('users')->findOrFail($id);
    }

    public function attachToUser($badgeId, $userId)
    {
        $badge = $this->find($badgeId);
        return $badge->users()->attach($userId);
    }

    public function detachFromUser($badgeId, $userId)
    {
        $badge = $this->find($badgeId);
        return $badge->users()->detach($userId);
    }
}

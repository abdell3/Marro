<?php

namespace App\Repositories\Interfaces;

interface BadgeRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find badge by name
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name);

    /**
     * Get users with badge
     * @param int $badgeId
     * @return mixed
     */
    public function getUsersWithBadge(int $badgeId);
}

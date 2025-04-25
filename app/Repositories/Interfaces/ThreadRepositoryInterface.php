<?php

namespace App\Repositories\Interfaces;

interface ThreadRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get threads by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId);

    /**
     * Get threads by community
     * @param int $communityId
     * @return mixed
     */
    public function getByCommunity(int $communityId);
}

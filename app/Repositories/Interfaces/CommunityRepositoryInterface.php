<?php

namespace App\Repositories\Interfaces;

interface CommunityRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find community by theme name
     * @param string $themeName
     * @return mixed
     */
    public function findByThemeName(string $themeName);

    /**
     * Get subscribers of community
     * @param int $communityId
     * @return mixed
     */
    public function getSubscribers(int $communityId);

    /**
     * Get posts from community
     * @param int $communityId
     * @return mixed
     */
    public function getPosts(int $communityId);

    /**
     * Get threads from community
     * @param int $communityId
     * @return mixed
     */
    public function getThreads(int $communityId);
}

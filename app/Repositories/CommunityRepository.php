<?php

namespace App\Repositories;

use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;

class CommunityRepository extends BaseRepository implements CommunityRepositoryInterface
{
    /**
     * CommunityRepository constructor.
     * @param Community $model
     */
    public function __construct(Community $model)
    {
        parent::__construct($model);
    }

    /**
     * Find community by theme name
     * @param string $themeName
     * @return mixed
     */
    public function findByThemeName(string $themeName)
    {
        return $this->model->where('theme_name', $themeName)->first();
    }

    /**
     * Get subscribers of community
     * @param int $communityId
     * @return mixed
     */
    public function getSubscribers(int $communityId)
    {
        $community = $this->find($communityId);
        return $community->abonnes;
    }

    /**
     * Get posts from community
     * @param int $communityId
     * @return mixed
     */
    public function getPosts(int $communityId)
    {
        $community = $this->find($communityId);
        return $community->posts;
    }

    /**
     * Get threads from community
     * @param int $communityId
     * @return mixed
     */
    public function getThreads(int $communityId)
    {
        $community = $this->find($communityId);
        return $community->threads;
    }
}

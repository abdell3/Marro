<?php

namespace App\Services;

use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use Illuminate\Support\Collection;

class CommunityService implements CommunityServiceInterface
{
    /**
     * @var CommunityRepositoryInterface
     */
    protected $communityRepository;

    /**
     * CommunityService constructor.
     * @param CommunityRepositoryInterface $communityRepository
     */
    public function __construct(CommunityRepositoryInterface $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    /**
     * Get all communities
     * @return Collection
     */
    public function getAllCommunities(): Collection
    {
        return collect($this->communityRepository->all());
    }

    /**
     * Get community by ID
     * @param int $id
     * @return Community
     */
    public function getCommunityById(int $id): Community
    {
        return $this->communityRepository->find($id);
    }

    /**
     * Create new community
     * @param array $data
     * @return Community
     */
    public function createCommunity(array $data): Community
    {
        return $this->communityRepository->create($data);
    }

    /**
     * Update community
     * @param int $id
     * @param array $data
     * @return Community
     */
    public function updateCommunity(int $id, array $data): Community
    {
        return $this->communityRepository->update($id, $data);
    }

    /**
     * Delete community
     * @param int $id
     * @return bool
     */
    public function deleteCommunity(int $id): bool
    {
        return $this->communityRepository->delete($id);
    }

    /**
     * Get community by theme name
     * @param string $themeName
     * @return Community|null
     */
    public function getCommunityByThemeName(string $themeName): ?Community
    {
        return $this->communityRepository->findByThemeName($themeName);
    }

    /**
     * Get subscribers of community
     * @param int $communityId
     * @return Collection
     */
    public function getCommunitySubscribers(int $communityId): Collection
    {
        return collect($this->communityRepository->getSubscribers($communityId));
    }

    /**
     * Get posts from community
     * @param int $communityId
     * @return Collection
     */
    public function getCommunityPosts(int $communityId): Collection
    {
        return collect($this->communityRepository->getPosts($communityId));
    }

    /**
     * Get threads from community
     * @param int $communityId
     * @return Collection
     */
    public function getCommunityThreads(int $communityId): Collection
    {
        return collect($this->communityRepository->getThreads($communityId));
    }

    /**
     * Get popular communities
     * @param int $limit
     * @return Collection
     */
    public function getPopularCommunities(int $limit = 10): Collection
    {
        // Get all communities
        $communities = $this->getAllCommunities();
        
        // Sort by number of subscribers
        $sortedCommunities = $communities->sortByDesc(function ($community) {
            return $community->abonnes->count();
        });
        
        // Limit results
        return $sortedCommunities->take($limit);
    }
}

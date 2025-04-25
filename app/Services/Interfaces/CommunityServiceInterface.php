<?php

namespace App\Services\Interfaces;

use App\Models\Community;
use Illuminate\Support\Collection;

interface CommunityServiceInterface
{
    /**
     * Get all communities
     * @return Collection
     */
    public function getAllCommunities(): Collection;
    
    /**
     * Get community by ID
     * @param int $id
     * @return Community
     */
    public function getCommunityById(int $id): Community;
    
    /**
     * Create new community
     * @param array $data
     * @return Community
     */
    public function createCommunity(array $data): Community;
    
    /**
     * Update community
     * @param int $id
     * @param array $data
     * @return Community
     */
    public function updateCommunity(int $id, array $data): Community;
    
    /**
     * Delete community
     * @param int $id
     * @return bool
     */
    public function deleteCommunity(int $id): bool;
    
    /**
     * Get community by theme name
     * @param string $themeName
     * @return Community|null
     */
    public function getCommunityByThemeName(string $themeName): ?Community;
    
    /**
     * Get subscribers of community
     * @param int $communityId
     * @return Collection
     */
    public function getCommunitySubscribers(int $communityId): Collection;
    
    /**
     * Get posts from community
     * @param int $communityId
     * @return Collection
     */
    public function getCommunityPosts(int $communityId): Collection;
    
    /**
     * Get threads from community
     * @param int $communityId
     * @return Collection
     */
    public function getCommunityThreads(int $communityId): Collection;
    
    /**
     * Get popular communities
     * @param int $limit
     * @return Collection
     */
    public function getPopularCommunities(int $limit = 10): Collection;
}

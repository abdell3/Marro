<?php

namespace App\Services;

use App\Repositories\CommunityRepository;

class CommunityService
{
    /**
     * Create a new class instance.
     */
    protected $communityRepository;

    public function __construct(CommunityRepository $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function getAllCommunities()
    {
        return $this->communityRepository->all();
    }

    public function getCommunityById($id)
    {
        return $this->communityRepository->find($id);
    }

    public function createCommunity(array $data)
    {
        return $this->communityRepository->create($data);
    }

    public function updateCommunity($id, array $data)
    {
        return $this->communityRepository->update($id, $data);
    }

    public function deleteCommunity($id)
    {
        return $this->communityRepository->delete($id);
    }
}

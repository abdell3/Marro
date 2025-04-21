<?php

namespace App\Services;

use App\Repositories\CommunityRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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

    public function getAllCommunities($perPage)
    {
        return $this->communityRepository->paginate($perPage);
    }

    public function getCommunityById($id)
    {
        return $this->communityRepository->find($id);
    }

    public function getCommunityBySlug($slug)
    {
        return $this->communityRepository->findBySlug($slug);
    }

    public function getPopularCommunities()
    {
        return $this->communityRepository->findPopular();
    }

    public function searchCommunities($query)
    {
        return $this->communityRepository->search($query);
    }

    public function createCommunity(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        $community = $this->communityRepository->create($data);
        
        
        $community->users()->attach(Auth::id());
        
        return $community;
    }

    public function updateCommunity($id, array $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return $this->communityRepository->update($id, $data);
    }

    public function deleteCommunity($id)
    {
        return $this->communityRepository->delete($id);
    }

    public function joinCommunity($communityId, $userId)
    {
        $community = $this->communityRepository->find($communityId);
        $community->users()->attach($userId);
        return $community;
    }

    public function leaveCommunity($communityId, $userId)
    {
        $community = $this->communityRepository->find($communityId);
        $community->users()->detach($userId);
        return $community;
    }


    // public function oldServiceLogique()
    // {
    //     protected $communityRepository;
    
    //     __construct(CommunityRepository $communityRepository)
        
    //         $this->communityRepository = $communityRepository;
        
    
    //     getAllCommunities()
        
    //         return $this->communityRepository->all();
        
    
    //     getCommunityById($id)
        
    //         return $this->communityRepository->find($id);
            
    //     createCommunity(array $data)
        
    //         return $this->communityRepository->create($data);
        
    
    //     updateCommunity($id, array $data)
        
    //         return $this->communityRepository->update($id, $data);
        
    
    //     deleteCommunity($id)
        
    //         return $this->communityRepository->delete($id);
        
    // }
}
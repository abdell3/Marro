<?php

namespace App\Repositories;


use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;

class CommunityRepository implements CommunityRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected $community;

    public function __construct(Community $community)
    {
        $this->community = $community;
    }

    public function all()
    {
        return $this->community->all();
    }

    public function find($id)
    {
        return $this->community->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->community->create($data);
    }

    public function update($id, array $data)
    {
        $community = $this->community->findOrFail($id);
        $community->update($data);
        return $community;
    }

    public function delete($id)
    {
        $community = $this->community->findOrFail($id);
        $community->delete();
        return $community;
    }

}
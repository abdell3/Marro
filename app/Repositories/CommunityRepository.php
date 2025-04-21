<?php

namespace App\Repositories;


use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;

class CommunityRepository extends BaseRepository implements CommunityRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function __construct(Community $model)
    {
        parent::__construct($model);
    }
 
    public function findBySlug($slug)
    {
        return $this->model->with('user')->where('slug', $slug)->firstOrFail();
    }
 
    public function findPopular()
    {
        return $this->model->withCount(['users', 'posts'])
            ->orderBy('users_count', 'desc')
            ->paginate(15);
    }
 
    public function search($query)
    {
        return $this->model->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->paginate(15);
    }

    public function paginate($perPage = 15)
    {
        return $this->model->with('user')->paginate($perPage);
    }
    
    // public function oldLogique()
    // {
    //     function all()
    //    {
    //        return $this->community->all();
    //    }
    
    //     function find($id)
    //    {
    //        return $this->community->findOrFail($id);
    //    }
    
    //     function create(array $data)
    //    {
    //        return $this->community->create($data);
    //    }
    
    //     function update($id, array $data)
    //    {
    //        $community = $this->community->findOrFail($id);
    //        $community->update($data);
    //        return $community;
    //    }
    
    //     function delete($id)
    //    {
    //        $community = $this->community->findOrFail($id);
    //        $community->delete();
    //        return $community;
    //    }

    // }
    
}
<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * Create a new class instance.
     */



    protected $post;
    protected $withRelations = [];
    protected $filters = [];
    protected $orderBy = [];


    public function __construct(Post $model)
    {
        parent::__construct( $model);
        
    }


    // public function testing()
    // {
    // // public function withRelations(array $relations)
    // // {
    // //     $this->withRelations = $relations;
    // //     return $this;
    // // }

    // // public function filterByCommunity(int $communityId)
    // // {
    // //     $this->filters['community_id'] = $communityId;
    // //     return $this;
    // // }


    // // public function filterByTag(int $tagId)
    // // {
    // //     $this->filters['tag_id'] = $tagId;
    // //     return $this;
    // // }
    

    // // // public function orderBy(string $column, string $direction = 'asc')
    // // // {
    // // //     $this->orderBy = [$column, $direction];
    // // //     return $this;
    // // // }


    // // public function paginate(int $perPage = 10): LengthAwarePaginator
    // // {
    // //     $query = $this->post->with($this->withRelations);

        
    // //     foreach ($this->filters as $key => $value) {
    // //         if ($key === 'tag_id') {
    // //             $query->whereHas('tags', function ($q) use ($value) {
    // //                 $q->where('tags.id', $value);
    // //             });
    // //         } else {
    // //             $query->where($key, $value);
    // //         }
    // //     }

        
    // //     if (!empty($this->orderBy)) {
    // //         $query->orderBy($this->orderBy[0], $this->orderBy[1]);
    // //     }

    // //     return $query->paginate($perPage);
    // // }


    // // public function allPosts()
    // // {
    // //     return $this->post->with($this->withRelations)->get();
    // // }

    // // public function findPost($id)
    // // {
    // //     return $this->post->with($this->withRelations)->findOrFail($id);  
    // // }

    // // public function createPost(array $data)
    // // {
    // //     return $this->post->create($data);
    // // }


    // // public function updatePost($id, array $data)
    // // {
    // //     $post = $this->post->findOrFail($id);
    // //     $post->update($data);
    // //     return $post;
    // // }


    // // public function deletePost($id)
    // // {
    // //     $post = $this->post->findOrFail($id);
    // //     $post->delete();
    // //     return $post;
    // // }
    // }
    

    public function findByCommunity($communityId)
    {
        return $this->model->where('community_id', $communityId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function findByUser($userId)
    {
        return $this->model->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function findPopular()
    {
        return $this->model->orderBy('upvotes', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function search($query)
    {
        return $this->model->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate(15);
    }


}

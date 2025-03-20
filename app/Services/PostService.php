<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    /**
     * Create a new class instance.
     */

    protected $postRepository;

     
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts($perPage)
    {
        return $this->postRepository
            ->withRelations(['user', 'community', 'tags'])
            ->paginate($perPage);   
    }


    public function getPostById($id)
    {
        return $this->postRepository
            ->withRelations(['user', 'community', 'tags', 'comments'])
            ->findPost($id);
    }

    public function createPost(array $data)
    {
        $post = $this->postRepository->createPost($data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function updatePost($id, array $data)
    {
        $post = $this->postRepository->updatePost($id, $data);

        
        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;

    }

    public function deletePost($id)
    {
        return $this->postRepository->deletePost($id);
    }


    public function filterByCommunity(int $communityId)
    {
        $this->postRepository->filterByCommunity($communityId);
        return $this;
    }

    public function filterByTag(int $tagId)
    {
        $this->postRepository->filterByTag($tagId);
        return $this;
    }


    // public function orderBy(string $column, string $direction = 'asc')
    // {
    //     $this->postRepository->orderBy($column, $direction);
    //     return $this;
    // }

}

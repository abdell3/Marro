<?php

namespace App\Services;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;

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
         return $this->postRepository->paginate($perPage);
     }
 
     public function getPostById($id)
     {
         return $this->postRepository->find($id);
     }
 
     public function getPostsByCommunity($communityId)
     {
         return $this->postRepository->findByCommunity($communityId);
     }
 
     public function getPostsByUser($userId)
     {
         return $this->postRepository->findByUser($userId);
     }
 
     public function getPopularPosts()
     {
         return $this->postRepository->findPopular();
     }
 
     public function searchPosts($query)
     {
         return $this->postRepository->search($query);
     }
 
     public function createPost(array $data)
     {
         $data['user_id'] = Auth::id();
         return $this->postRepository->create($data);
     }
 
     public function updatePost($id, array $data)
     {
         return $this->postRepository->update($id, $data);
     }
 
     public function deletePost($id)
     {
         return $this->postRepository->delete($id);
     }
 
     public function upvotePost($id)
     {
         $post = $this->postRepository->find($id);
         $post->upvotes += 1;
         $post->save();
         return $post;
     }
 
     public function downvotePost($id)
     {
         $post = $this->postRepository->find($id);
         $post->downvotes += 1;
         $post->save();
         return $post;
     }



    // public function oldServiceLogique()
    // {
    //     //  function getAllPosts($perPage)
    //     // {
    //     //     return $this->postRepository
    //     //         ->$withRelations(['user', 'community', 'tags'])
    //     //         ->paginate($perPage);   
    //     // }
    
    
    //     //  function getPostById($id)
    //     // {
    //     //     return $this->postRepository
    //     //         ->withRelations(['user', 'community', 'tags', 'comments'])
    //     //         ->findPost($id);
    //     // }
    
    //     //  function createPost(array $data)
    //     // {
    //     //     $post = $this->postRepository->createPost($data);
    
    //     //     if (isset($data['tags'])) {
    //     //         $post->tags()->sync($data['tags']);
    //     //     }
    
    //     //     return $post;
    //     // }
    
    //     //  function updatePost($id, array $data)
    //     // {
    //     //     $post = $this->postRepository->updatePost($id, $data);
    
            
    //     //     if (isset($data['tags'])) {
    //     //         $post->tags()->sync($data['tags']);
    //     //     }
    
    //     //     return $post;
    
    //     // }
    
    //     //  function deletePost($id)
    //     // {
    //     //     return $this->postRepository->deletePost($id);
    //     // }
    
    
    //     //  function filterByCommunity(int $communityId)
    //     // {
    //     //     $this->postRepository->filterByCommunity($communityId);
    //     //     return $this;
    //     // }
    
    //     //  function filterByTag(int $tagId)
    //     // {
    //     //     $this->postRepository->filterByTag($tagId);
    //     //     return $this;
    //     // }
    
    
    //     // public function orderBy(string $column, string $direction = 'asc')
    //     // {
    //     //     $this->postRepository->orderBy($column, $direction);
    //     //     return $this;
    //     // }
    // }
    




}

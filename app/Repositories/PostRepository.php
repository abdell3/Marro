<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * PostRepository constructor.
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * Get posts by user
     * @param int $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('auteur_id', $userId)->get();
    }

    /**
     * Get posts by community
     * @param int $communityId
     * @return mixed
     */
    public function getByCommunity(int $communityId)
    {
        return $this->model->where('community_id', $communityId)->get();
    }

    /**
     * Get posts by tag
     * @param int $tagId
     * @return mixed
     */
    public function getByTag(int $tagId)
    {
        return $this->model->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tags.id', $tagId);
        })->get();
    }

    /**
     * Get most popular posts
     * @param int $limit
     * @return mixed
     */
    public function getMostPopular(int $limit = 10)
    {
        return $this->model->orderBy('like', 'desc')->limit($limit)->get();
    }

    /**
     * Add tag to post
     * @param int $postId
     * @param int $tagId
     * @return mixed
     */
    public function addTag(int $postId, int $tagId)
    {
        $post = $this->find($postId);
        return $post->tags()->attach($tagId);
    }

    /**
     * Remove tag from post
     * @param int $postId
     * @param int $tagId
     * @return mixed
     */
    public function removeTag(int $postId, int $tagId)
    {
        $post = $this->find($postId);
        return $post->tags()->detach($tagId);
    }

    /**
     * Update post likes count
     * @param int $postId
     * @param int $delta
     * @return mixed
     */
    public function updateLikes(int $postId, int $delta)
    {
        $post = $this->find($postId);
        $post->like += $delta;
        return $post->save();
    }
}

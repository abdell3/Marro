<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    /**
     * TagRepository constructor.
     * @param Tag $model
     */
    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    /**
     * Find tag by title
     * @param string $title
     * @return mixed
     */
    public function findByTitle(string $title)
    {
        return $this->model->where('title', $title)->first();
    }

    /**
     * Get posts for tag
     * @param int $tagId
     * @return mixed
     */
    public function getPosts(int $tagId)
    {
        $tag = $this->find($tagId);
        return $tag->posts;
    }
}

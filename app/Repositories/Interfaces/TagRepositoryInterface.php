<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find tag by title
     * @param string $title
     * @return mixed
     */
    public function findByTitle(string $title);

    /**
     * Get posts for tag
     * @param int $tagId
     * @return mixed
     */
    public function getPosts(int $tagId);
}

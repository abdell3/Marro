<?php

namespace App\Repositories\Interfaces;

interface SavedPostRepositoryInterface extends RepositoryInterface
{
    public function findByUser($userId);
    public function findByUserAndPost($userId, $postId);
}

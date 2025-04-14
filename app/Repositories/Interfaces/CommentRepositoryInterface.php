<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function findByPost($postId);
    public function findByUser($userId);
    public function findReplies($commentId);
}

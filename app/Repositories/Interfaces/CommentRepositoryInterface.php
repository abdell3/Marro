<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{
    public function allComments();
    public function findComment($id);
    public function createComment(array $data);
    public function updateComment($id, array $data);
    public function deleteComment($id);
}

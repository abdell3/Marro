<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    /**
     * Create a new class instance.
     */


    protected $commentRepository;


    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComment()
    {
        return $this->commentRepository->allComments();
    }

    public function getCommentById($id)
    {
        return $this->commentRepository->findComment($id);
    }

    public function createComment(array $data)
    {
        return $this->commentRepository->createComment($data);
    }

    public function updateComment(array $data, $id)
    {
        return $this->commentRepository->updateComment($id, $data);
    }

    public function deleteComment($id)
    {
        return $this->commentRepository->deleteComment($id);
    }
}

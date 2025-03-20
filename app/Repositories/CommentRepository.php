<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    protected $comment;


    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function allComments()
    {
        return $this->comment->all();
    }

    public function findComment($id)
    {
        return $this->comment->findOrFail($id);
    }


    public function createComment(array $data)
    {
        return $this->comment->create($data);
    }

    public function updateComment($id, array $data)
    {
        $comment = $this->comment->findOrFail($id);
        $comment->update($data);
        return $comment;
    }

    public function deleteComment($id)
    {
        $comment = $this->comment->findOrFail($id);
        $comment->delete();
        return $comment;
    }
}

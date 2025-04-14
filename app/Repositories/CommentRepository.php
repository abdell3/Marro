<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface 
{
    /**
     * Create a new class instance.
     */

     public function __construct(Comment $model)
     {
         parent::__construct($model);
     }
 
     public function findByPost($postId)
     {
         return $this->model->where('post_id', $postId)
             ->whereNull('parent_id')
             ->orderBy('created_at', 'desc')
             ->get();
     }
 
     public function findByUser($userId)
     {
         return $this->model->where('user_id', $userId)
             ->orderBy('created_at', 'desc')
             ->paginate(15);
     }
 
     public function findReplies($commentId)
     {
         return $this->model->where('parent_id', $commentId)
             ->orderBy('created_at', 'asc')
             ->get();
     }
}

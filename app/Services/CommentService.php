<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    /**
     * Create a new class instance.
     */


     protected $commentRepository;

     public function __construct(CommentRepositoryInterface $commentRepository)
     {
         $this->commentRepository = $commentRepository;
     }
 
     public function getAllComments($perPage)
     {
         return $this->commentRepository->paginate($perPage);
     }
 
     public function getCommentById($id)
     {
         return $this->commentRepository->find($id);
     }
 
     public function getCommentsByPost($postId)
     {
         return $this->commentRepository->findByPost($postId);
     }
 
     public function getCommentsByUser($userId)
     {
         return $this->commentRepository->findByUser($userId);
     }
 
     public function getReplies($commentId)
     {
         return $this->commentRepository->findReplies($commentId);
     }
 
     public function createComment(array $data)
     {
         $data['user_id'] = Auth::id();
         return $this->commentRepository->create($data);
     }
 
     public function updateComment($id, array $data)
     {
         return $this->commentRepository->update($id, $data);
     }
 
     public function deleteComment($id)
     {
         return $this->commentRepository->delete($id);
     }
 
     public function upvoteComment($id)
     {
         $comment = $this->commentRepository->find($id);
         $comment->upvotes += 1;
         $comment->save();
         return $comment;
     }
 
     public function downvoteComment($id)
     {
         $comment = $this->commentRepository->find($id);
         $comment->downvotes += 1;
         $comment->save();
         return $comment;
     }
}

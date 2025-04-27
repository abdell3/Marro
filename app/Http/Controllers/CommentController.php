<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\BadgeServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Observers\UserBadgeObserver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @var CommentServiceInterface
     */
    protected $commentService;

    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * @var BadgeServiceInterface
     */
    protected $badgeService;

    /**
     * @var UserBadgeObserver
     */
    protected $badgeObserver;

    /**
     * CommentController constructor.
     */
    public function __construct(
        CommentServiceInterface $commentService,
        AuthServiceInterface $authService,
        BadgeServiceInterface $badgeService
    ) {
        $this->commentService = $commentService;
        $this->authService = $authService;
        $this->badgeService = $badgeService;
        $this->badgeObserver = new UserBadgeObserver($badgeService);
        
        // Apply auth middleware for all actions
        $this->middleware('auth');
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => ['required', 'exists:posts,id'],
            'contenu' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authService->user();

        $comment = $this->commentService->createComment([
            'post_id' => $request->input('post_id'),
            'auteur_id' => $user->id,
            'parent_id' => $request->input('parent_id'),
            'contenu' => $request->input('contenu'),
        ]);

        // Check for badges after creating a comment
        $this->badgeObserver->commentCreated($comment);

        return redirect()->route('posts.show', $request->input('post_id'))
            ->with('success', 'Commentaire ajouté avec succès.')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     * Show reply form for a specific comment.
     */
    public function reply($id)
    {
        $comment = $this->commentService->getCommentById($id);
        
        return view('comments.reply', [
            'comment' => $comment
        ]);
    }
    
    /**
     * Store a reply to a comment.
     */
    public function storeReply(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'contenu' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $parentComment = $this->commentService->getCommentById($id);
        $user = $this->authService->user();

        $comment = $this->commentService->createComment([
            'post_id' => $parentComment->post_id,
            'auteur_id' => $user->id,
            'parent_id' => $id,
            'contenu' => $request->input('contenu'),
        ]);

        // Check for badges after creating a reply (which is also a comment)
        $this->badgeObserver->commentCreated($comment);

        return redirect()->route('posts.show', $parentComment->post_id)
            ->with('success', 'Réponse ajoutée avec succès.')
            ->withFragment('comment-' . $comment->id);
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit($id)
    {
        $user = $this->authService->user();
        $comment = $this->commentService->getCommentById($id);

        // Check if user is the author or has permission to edit others' comments
        if ($comment->auteur_id !== $user->id && !$user->hasPermission('edit-any-comment')) {
            return redirect()->route('posts.show', $comment->post_id)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire.');
        }

        return view('comments.edit', [
            'comment' => $comment
        ]);
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'contenu' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authService->user();
        $comment = $this->commentService->getCommentById($id);

        // Check if user is the author or has permission to edit others' comments
        if ($comment->auteur_id !== $user->id && !$user->hasPermission('edit-any-comment')) {
            return redirect()->route('posts.show', $comment->post_id)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce commentaire.');
        }

        $comment = $this->commentService->updateComment($id, [
            'contenu' => $request->input('contenu'),
        ]);

        return redirect()->route('posts.show', $comment->post_id)
            ->with('success', 'Commentaire mis à jour avec succès.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy($id)
    {
        $user = $this->authService->user();
        $comment = $this->commentService->getCommentById($id);

        // Check if user is the author or has permission to delete others' comments
        if ($comment->auteur_id !== $user->id && !$user->hasPermission('delete-any-comment')) {
            return redirect()->route('posts.show', $comment->post_id)
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce commentaire.');
        }

        $postId = $comment->post_id;
        $this->commentService->deleteComment($id);

        return redirect()->route('posts.show', $postId)
            ->with('success', 'Commentaire supprimé avec succès.');
    }

    /**
     * Report a comment.
     */
    public function report(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'reason' => ['required', 'string'],
            'report_type_id' => ['required', 'exists:report_types,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authService->user();
        $comment = $this->commentService->getCommentById($id);

        $result = $this->commentService->reportComment(
            $id,
            $user->id,
            $request->input('reason'),
            $request->input('report_type_id')
        );

        return redirect()->route('posts.show', $comment->post_id)
            ->with('success', 'Commentaire signalé avec succès.');
    }
}

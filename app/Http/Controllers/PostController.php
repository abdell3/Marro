<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\ReportTypeServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * @var PostServiceInterface
     */
    protected $postService;

    /**
     * @var CommentServiceInterface
     */
    protected $commentService;

    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * @var CommunityServiceInterface
     */
    protected $communityService;

    /**
     * @var TagServiceInterface
     */
    protected $tagService;

    /**
     * @var ReportTypeServiceInterface
     */
    protected $reportTypeService;

    /**
     * PostController constructor.
     */
    public function __construct(
        PostServiceInterface $postService,
        CommentServiceInterface $commentService,
        AuthServiceInterface $authService,
        CommunityServiceInterface $communityService
    ) {
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->authService = $authService;
        $this->communityService = $communityService;
        
        // Apply auth middleware for most actions
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of posts.
     */
    public function index()
    {
        $user = $this->authService->user();
        $posts = $this->postService->getPostsByUser($user->id);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(Request $request)
    {
        $communityId = $request->query('community_id');
        $communities = $this->communityService->getAllCommunities();

        return view('posts.create', [
            'communities' => $communities,
            'selectedCommunityId' => $communityId
        ]);
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'typeContenu' => ['required', 'in:text,image,link,video'],
            'community_id' => ['required', 'exists:communities,id'],
            'media' => ['nullable', 'file', 'max:20480'], // 20MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authService->user();
        $mediaPath = null;
        $mediaType = null;
        
        // Handle media upload
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $file = $request->file('media');
            $fileType = $file->getMimeType();
            
            // Validate file type based on selected post type
            $typeContenu = $request->input('typeContenu');
            
            if ($typeContenu === 'image' && !str_starts_with($fileType, 'image/')) {
                return redirect()->back()
                    ->withErrors(['media' => 'Le fichier doit être une image.'])
                    ->withInput();
            }
            
            if ($typeContenu === 'video' && !str_starts_with($fileType, 'video/')) {
                return redirect()->back()
                    ->withErrors(['media' => 'Le fichier doit être une vidéo.'])
                    ->withInput();
            }
            
            // Store file based on type
            $subFolder = $typeContenu === 'image' ? 'images' : 'videos';
            $mediaPath = $file->store('posts/' . $subFolder, 'public');
            $mediaType = $fileType;
        }

        $post = $this->postService->createPost([
            'titre' => $request->input('titre'),
            'contenu' => $request->input('contenu'),
            'typeContenu' => $request->input('typeContenu'),
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'community_id' => $request->input('community_id'),
            'auteur_id' => $user->id,
        ]);

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Post créé avec succès.');
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        $comments = $this->commentService->getCommentsByPost($id);
        
        // Charger les auteurs pour tous les commentaires
        $comments->load('auteur');

        return view('posts.show', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $user = $this->authService->user();
        $post = $this->postService->getPostById($id);

        // Check if user is the author or has permission to edit others' posts
        if ($post->auteur_id !== $user->id && !$user->hasPermission('edit-any-post')) {
            return redirect()->route('posts.show', $post->id)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
        }

        $communities = $this->communityService->getAllCommunities();

        return view('posts.edit', [
            'post' => $post,
            'communities' => $communities
        ]);
    }

    /**
     * Update the specified post in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titre' => ['required', 'string', 'max:255'],
            'contenu' => ['required', 'string'],
            'typeContenu' => ['required', 'in:text,image,link,video'],
            'community_id' => ['required', 'exists:communities,id'],
            'media' => ['nullable', 'file', 'max:20480'], // 20MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authService->user();
        $post = $this->postService->getPostById($id);

        // Check if user is the author or has permission to edit others' posts
        if ($post->auteur_id !== $user->id && !$user->hasPermission('edit-any-post')) {
            return redirect()->route('posts.show', $post->id)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce post.');
        }

        $data = [
            'titre' => $request->input('titre'),
            'contenu' => $request->input('contenu'),
            'typeContenu' => $request->input('typeContenu'),
            'community_id' => $request->input('community_id'),
        ];
        
        // Handle media upload
        if ($request->hasFile('media') && $request->file('media')->isValid()) {
            $file = $request->file('media');
            $fileType = $file->getMimeType();
            
            // Validate file type based on selected post type
            $typeContenu = $request->input('typeContenu');
            
            if ($typeContenu === 'image' && !str_starts_with($fileType, 'image/')) {
                return redirect()->back()
                    ->withErrors(['media' => 'Le fichier doit être une image.'])
                    ->withInput();
            }
            
            if ($typeContenu === 'video' && !str_starts_with($fileType, 'video/')) {
                return redirect()->back()
                    ->withErrors(['media' => 'Le fichier doit être une vidéo.'])
                    ->withInput();
            }
            
            // Delete old media if exists
            if ($post->media_path) {
                $oldMediaPath = storage_path('app/public/' . $post->media_path);
                if (file_exists($oldMediaPath)) {
                    unlink($oldMediaPath);
                }
            }
            
            // Store new file based on type
            $subFolder = $typeContenu === 'image' ? 'images' : 'videos';
            $mediaPath = $file->store('posts/' . $subFolder, 'public');
            
            // Add to update data
            $data['media_path'] = $mediaPath;
            $data['media_type'] = $fileType;
        } else if ($request->has('remove_media') && $request->input('remove_media') == 1) {
            // Remove existing media if requested
            if ($post->media_path) {
                $oldMediaPath = storage_path('app/public/' . $post->media_path);
                if (file_exists($oldMediaPath)) {
                    unlink($oldMediaPath);
                }
            }
            
            $data['media_path'] = null;
            $data['media_type'] = null;
        }

        $post = $this->postService->updatePost($id, $data);

        return redirect()->route('posts.show', $post->id)
            ->with('success', 'Post mis à jour avec succès.');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        $user = $this->authService->user();
        $post = $this->postService->getPostById($id);

        // Check if user is the author or has permission to delete others' posts
        if ($post->auteur_id !== $user->id && !$user->hasPermission('delete-any-post')) {
            return redirect()->route('posts.show', $post->id)
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce post.');
        }

        $this->postService->deletePost($id);

        return redirect()->route('posts.index')
            ->with('success', 'Post supprimé avec succès.');
    }

    /**
     * Vote on a post.
     */
    public function vote(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'vote_type' => ['required', 'in:upvote,downvote'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Type de vote invalide.'
            ]);
        }

        $user = $this->authService->user();
        $voteType = $request->input('vote_type');

        $result = $this->postService->voteOnPost($id, $user->id, $voteType);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Vote enregistré.' : 'Erreur lors du vote.'
        ]);
    }

    /**
     * Save a post for later.
     */
    public function save($id)
    {
        $user = $this->authService->user();

        $result = $user->savedPosts()->toggle($id);

        $isSaved = count($result['attached']) > 0;

        return response()->json([
            'success' => true,
            'isSaved' => $isSaved,
            'message' => $isSaved ? 'Post sauvegardé.' : 'Post retiré des favoris.'
        ]);
    }

    /**
     * Report a post.
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

        $result = $this->postService->reportPost(
            $id,
            $user->id,
            $request->input('reason'),
            $request->input('report_type_id')
        );

        return redirect()->route('posts.show', $id)
            ->with('success', 'Post signalé avec succès.');
    }
}

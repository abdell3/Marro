<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        if ($request->has('community_id')) {
            $posts = $this->postService->getPostsByCommunity($request->community_id);
        } elseif ($request->has('user_id')) {
            $posts = $this->postService->getPostsByUser($request->user_id);
        } elseif ($request->has('popular')) {
            $posts = $this->postService->getPopularPosts();
        } elseif ($request->has('search')) {
            $posts = $this->postService->searchPosts($request->search);
        } else {
            $posts = $this->postService->getAllPosts($request->input('per_page', 10));
        }

        return view('posts.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $post = $this->postService->createPost($request->validated());
        return redirect()->route('posts.show', $post->id)->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = $this->postService->getPostById($id);
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $postId)
    {

        $post = $this->postService->getPostById($postId);
        $this->authorize('update', $post);
        $this->postService->updatePost($postId, $request->validated());
        return redirect()->route('posts.show', $postId)->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId)
    {
        $post = $this->postService->getPostById($postId);
        $this->authorize('delete', $post);
        $this->postService->deletePost($postId);
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }


    public function upvote($postId)
    {
        $this->postService->upvotePost($postId);
        return back();
    }

    public function downvote($postId)
    {
        $this->postService->downvotePost($postId);
        return back();
    }


}

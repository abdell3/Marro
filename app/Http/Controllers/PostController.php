<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
        $this->postService =$postService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $communityId = $request->input('community_id');
        $tagId = $request->input('tag_id'); 
        $orderBy = $request->input('order_by', 'created_at'); 
        $orderDirection = $request->input('order_direction', 'desc'); 

        
        $posts = $this->postService
            ->filterByCommunity($communityId) 
            ->filterByTag($tagId) 
            // ->orderBy($orderBy, $orderDirection) 
            ->getAllPosts($perPage); 

        return view('post.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('post', 'view'); 
            $request['file_path'] = $path; 
        }

        
        $post = $this->postService->createPost($request->validated());


        if (isset($request['tags'])) {
            $post->tags()->sync($request['tags']); 
        }



        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.update', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, $postId)
    {

        $post = $this->postService->updatePost($postId, $request->validated());
        if (isset($request['tags'])) {
            $post->tags()->sync($request['tags']);
        }
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId)
    {
        $this->postService->deletePost($postId);
        return redirect()->route('post.index');
    }
}

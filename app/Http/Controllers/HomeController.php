<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Services\CommunityService;
use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $postService;
    protected $communityService;

    public function __construct(PostService $postService, CommunityService $communityService)
    {
        $this->postService = $postService;
        $this->communityService = $communityService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $posts = $this->postService
            ->getAllPosts($perPage);


        $communities = $this->communityService
            ->getAllCommunities();
            


        // $communities = Community::withCount('posts')
        //     ->orderBy('posts_count', 'desc') 
        //     ->take(5)
        //     ->get();

        return view('home', compact('posts', 'communities'));
    }
}

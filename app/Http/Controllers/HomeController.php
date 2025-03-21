<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $posts = $this->postService
            ->getAllPosts($perPage);

        return view('home', compact('posts'));
    }
}

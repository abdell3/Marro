<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var PostServiceInterface
     */
    protected $postService;

    /**
     * @var CommunityServiceInterface
     */
    protected $communityService;

    /**
     * HomeController constructor.
     * 
     * @param PostServiceInterface $postService
     * @param CommunityServiceInterface $communityService
     */
    public function __construct(
        PostServiceInterface $postService,
        CommunityServiceInterface $communityService
    ) {
        $this->postService = $postService;
        $this->communityService = $communityService;
    }

    /**
     * Display the home page with latest posts.
     */
    public function index(Request $request)
    {
        try {
            // Get latest posts
            $posts = $this->postService->getAllPosts();
            
            // Sort by latest by default
            $filter = $request->input('filter', 'latest');
            
            if ($filter === 'popular') {
                $posts = $posts->sortByDesc('like');
            } else {
                $posts = $posts->sortByDesc('datePublication');
            }
            
            // Get popular communities for sidebar
            $popularCommunities = $this->communityService->getPopularCommunities(5);
            
            return view('home', [
                'posts' => $posts,
                'popularCommunities' => $popularCommunities,
                'filter' => $filter
            ]);
        } catch (\Exception $e) {
            // Si une erreur se produit, afficher une page d'accueil simplifiée
            return view('home', [
                'posts' => collect(),
                'popularCommunities' => collect(),
                'filter' => 'latest'
            ]);
        }
    }

    /**
     * Search posts and communities.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // In a real implementation, we would search for posts and communities
        // Here we're just returning the view with empty results
        
        return view('search', [
            'query' => $query,
            'posts' => collect(),
            'communities' => collect()
        ]);
    }
    
    /**
     * Display the welcome page with Tailwind styling.
     */
    public function welcome()
    {
        return view('welcome');
    }
}

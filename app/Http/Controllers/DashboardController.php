<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use App\Services\CommentService;
use App\Services\CommunityService;
use App\Services\PostService;
use App\Services\ThreadService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $postService;
    protected $communityService;
    protected $commentService;
    protected $threadService;
    protected $userService;


    public function __construct(PostService $post, CommentService $comment, CommunityService $community, UserService $user, ThreadService $thread)
    {
        $this->middleware('auth');


        $this->postService = $post;
        $this->threadService = $thread;
        $this->commentService = $comment;
        $this->communityService = $community;
        $this->userService = $user;

    }

    /**
     * Show the user dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $sort = $request->input('sort', 'popular');
        $id = $request->input('id');
        $posts = $this->getPostsBySort($sort);
        // $activities = $this->getUserActivities();

        $userCommunities = $this->communityService->getCommunityById($id);


        $trendingCommunities = $this->communityService->getPopularCommunities();
       
        $userCommunities = $user->communities()
            ->withCount('users as members_count')
            ->orderBy('members_count', 'desc')
            ->take(5)
            ->get();
        
        
        $trendingCommunities = Community::withCount('users as members_count')
            ->orderBy('members_count', 'desc')
            ->take(5)
            ->get();
        
            return view('auth.dashboard', compact(
                'posts', 
                'activities', 
                'userCommunities', 
                'trendingCommunities'
        ));
    }
    
    /**
     * Get posts based on sort parameter.
     *
     * @param  string  $sort
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

    private function getPosts($sort)
    {
        $query = Post::with(['user', 'community'])
            ->withCount(['comments', 'votes' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(value), 0)'));
            }]);
        
        // Apply sorting
        switch ($sort) {
            case 'new':
                $query->latest();
                break;
            case 'top':
                $query->orderByDesc('votes_count');
                break;
            case 'popular':
            default:
               
                $query->orderByRaw('(votes_count * 10 + comments_count) DESC')
                      ->orderByDesc('created_at');
                break;
        }
        
        
        $userCommunityIds = Auth::user()->communities()->pluck('communities.id');
        if ($userCommunityIds->isNotEmpty()) {
            $query->whereIn('community_id', $userCommunityIds);
        }
        
        return $query->paginate(10);
    }
    
    /**
     * Get user's recent activities.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUserActivities($user)
    {
        
        $posts = $user->posts()
            ->with('community')
            ->select('id', 'title', 'user_id', 'community_id', 'created_at')
            ->selectRaw("'post' as type")
            ->selectRaw("CONCAT('/posts/', id) as url")
            ->latest()
            ->take(3);
            
        $comments = $user->comments()
            ->with('post.community')
            ->select('comments.id', 'posts.title', 'comments.user_id', 'posts.community_id', 'comments.created_at')
            ->selectRaw("'comment' as type")
            ->selectRaw("CONCAT('/posts/', posts.id, '#comment-', comments.id) as url")
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->latest()
            ->take(3);
            
        // Union the queries and get the latest 5 activities
        return $posts->union($comments)
            ->latest()
            ->take(5)
            ->get();
    }
}
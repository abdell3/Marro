<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    /**
     * @var CommunityServiceInterface
     */
    protected $communityService;

    /**
     * @var PostServiceInterface
     */
    protected $postService;

    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * CommunityController constructor.
     */
    public function __construct(
        CommunityServiceInterface $communityService,
        PostServiceInterface $postService,
        AuthServiceInterface $authService
    ) {
        $this->communityService = $communityService;
        $this->postService = $postService;
        $this->authService = $authService;
        
        // Apply auth middleware for specific actions
        $this->middleware('auth')->except(['index', 'show']);
        
        // Apply permission middleware for admin/mod actions
        $this->middleware('permission:create-community')->only(['create', 'store']);
        $this->middleware('permission:update-community')->only(['edit', 'update']);
        $this->middleware('permission:delete-community')->only(['destroy']);
    }

    /**
     * Display a listing of communities.
     */
    public function index()
    {
        $communities = $this->communityService->getAllCommunities();

        return view('communities.index', [
            'communities' => $communities
        ]);
    }

    /**
     * Show the form for creating a new community.
     */
    public function create()
    {
        return view('communities.create');
    }

    /**
     * Store a newly created community in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'theme_name' => ['required', 'string', 'max:255', 'unique:communities'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $community = $this->communityService->createCommunity([
            'theme_name' => $request->input('theme_name'),
            'description' => $request->input('description'),
        ]);

        // Subscribe the creator to the community
        $user = $this->authService->user();
        $user->communities()->attach($community->id);

        return redirect()->route('communities.show', $community->id)
            ->with('success', 'Communauté créée avec succès.');
    }

    /**
     * Display the specified community.
     */
    public function show($id, Request $request)
    {
        $community = $this->communityService->getCommunityById($id);
        $posts = $this->communityService->getCommunityPosts($id);
        
        // Sort by latest by default
        $filter = $request->input('filter', 'latest');
        
        if ($filter === 'popular') {
            $posts = $posts->sortByDesc('like');
        } else {
            $posts = $posts->sortByDesc('datePublication');
        }

        return view('communities.show', [
            'community' => $community,
            'posts' => $posts,
            'filter' => $filter
        ]);
    }

    /**
     * Show the form for editing the specified community.
     */
    public function edit($id)
    {
        $community = $this->communityService->getCommunityById($id);

        return view('communities.edit', [
            'community' => $community
        ]);
    }

    /**
     * Update the specified community in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'theme_name' => ['required', 'string', 'max:255', 'unique:communities,theme_name,'.$id],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $community = $this->communityService->updateCommunity($id, [
            'theme_name' => $request->input('theme_name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('communities.show', $community->id)
            ->with('success', 'Communauté mise à jour avec succès.');
    }

    /**
     * Remove the specified community from storage.
     */
    public function destroy($id)
    {
        $this->communityService->deleteCommunity($id);

        return redirect()->route('communities.index')
            ->with('success', 'Communauté supprimée avec succès.');
    }

    /**
     * Subscribe/unsubscribe from a community.
     */
    public function toggleSubscription($id)
    {
        $user = $this->authService->user();
        
        // Toggle subscription using Eloquent relationship
        $result = $user->communities()->toggle($id);
        
        $isSubscribed = count($result['attached']) > 0;
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'isSubscribed' => $isSubscribed,
                'message' => $isSubscribed ? 'Abonné avec succès.' : 'Désabonné avec succès.'
            ]);
        }
        
        return redirect()->back()
            ->with('success', $isSubscribed ? 'Abonné avec succès.' : 'Désabonné avec succès.');
    }
}

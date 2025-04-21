<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Services\CommunityService;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    protected $communityService;
     
    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function index(Request $request)
    {

        $user = Auth::user();

        // $communities =$this->communityService->getAllCommunities(10);
        if($user->hasRole('Admin'))
        {
            $communities = $this->communityService->getAllCommunities(10);

            foreach ($communities as $community) {
                $community->loadCount('users', 'posts');
            }
            return  view('admin.communities.index', compact('communities'));
        }

        elseif ($user->hasRole('User')) {  
            if($request->has('popular')) {
                $communities = $this->communityService->getPopularCommunities();
            }elseif($request->has('search')) {
                $communities = $this->communityService->searchCommunities($request->search);
            }else{
                $communities = $this->communityService->getAllCommunities(10);
            }
            return view('communities.index', compact('communities'));  
        } 
        return view('communities.index', compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('communities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommunityRequest $request)
    {
        $community = $this->communityService->createCommunity($request->validated());
        return redirect()->route('communities.show', $community->slug)->with(
            'success', 
            'Community created successfully.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $community = $this->communityService->getCommunityBySlug($slug);
        return view('communities.show', compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $community = $this->communityService->getCommunityById($id);
        $this->authorize('update', $community);
        return view('communities.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommunityRequest $request, $id)
    {
        $community = $this->communityService->getCommunityById($id);
        $this->authorize(
            'update', 
            $community
        );

        $this->communityService->updateCommunity(
            $id, 
            $request->validated()
        );

        return redirect()->route('communities.show', $community->slug)->with(
            'success', 
            'Community updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $community = $this->communityService->getCommunityById($id);
        $this->authorize('delete', $community);
        $this->communityService->deleteCommunity($id);
        return redirect()->route('communities.index')->with('success', 'Community deleted successfully.');
    }


    public function join($id)
    {
        $this->communityService->joinCommunity($id, Auth::id());
        return back()->with('success', 'Joined community successfully.');
    }


    public function leave($id)
    {
        $this->communityService->leaveCommunity($id, Auth::id());
        return back()->with('success', 'Left community successfully.');
    }

    
}


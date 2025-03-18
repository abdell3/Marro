<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Services\CommunityService;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    protected $communityService;
     
    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }


    public function index()
    {
        $communities = $this->communityService->getAllCommunities();
        return view('communities.index', compact('communities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommunityRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:communities',
            'slug' => 'required|string|max:255|unique:communities',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->communityService->createCommunity($data);
        return redirect()->route('communities.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $community, $id)
    {
        $community = $this->communityService->getCommunityById($id);
        return view('communities.show', compact('community'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommunityRequest $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $id,
            'slug' => 'required|string|max:255|unique:communities,slug,' . $id,
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $this->communityService->updateCommunity($id, $data);
        return redirect()->route('communities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->communityService->deleteCommunity($id);
        return redirect()->route('communities.index');
    }
}


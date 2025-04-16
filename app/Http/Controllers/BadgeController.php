<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Http\Requests\StoreBadgeRequest;
use App\Http\Requests\UpdateBadgeRequest;
use App\Services\BadgeService;
use App\Services\UserService;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $badgeService;
    protected $userService;

    public function __construct(BadgeService $badgeService, UserService $userService)
    {
        $this->badgeService = $badgeService;
        $this->userService = $userService;
        $this->middleware('auth');
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    public function index()
    {
        $badges = $this->badgeService->getAllBadges();
        return view('badges.index', compact('badges'));
    }

    public function create()
    {
        return view('admin.badges.create');
    }

    public function store(StoreBadgeRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('badges', 'public');
        }
        
        $this->badgeService->createBadge($data);
        return redirect()->route('admin.badges.index')->with('success', 'Badge created successfully.');
    }

    public function show($id)
    {
        $badge = $this->badgeService->getBadgeWithUsers($id);
        return view('badges.show', compact('badge'));
    }

    public function edit($id)
    {
        $badge = $this->badgeService->getBadgeById($id);
        return view('admin.badges.edit', compact('badge'));
    }

    public function update(UpdateBadgeRequest $request, $id)
    {
        $data = $request->validated();
        
        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('badges', 'public');
        }
        
        $this->badgeService->updateBadge($id, $data);
        return redirect()->route('admin.badges.index')->with('success', 'Badge updated successfully.');
    }

    public function destroy($id)
    {
        $this->badgeService->deleteBadge($id);
        return redirect()->route('admin.badges.index')->with('success', 'Badge deleted successfully.');
    }

    public function awardBadge(Request $request)
    {
        $request->validate([
            'badge_id' => 'required|exists:badges,id',
            'user_id' => 'required|exists:users,id',
        ]);
        
        $this->badgeService->awardBadgeToUser($request->badge_id, $request->user_id);
        return redirect()->back()->with('success', 'Badge awarded successfully.');
    }

    public function revokeBadge(Request $request)
    {
        $request->validate([
            'badge_id' => 'required|exists:badges,id',
            'user_id' => 'required|exists:users,id',
        ]);
        
        $this->badgeService->revokeBadgeFromUser($request->badge_id, $request->user_id);
        return redirect()->back()->with('success', 'Badge revoked successfully.');
    }


    
}

<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use App\Http\Requests\StoreSavedPostRequest;
use App\Http\Requests\UpdateSavedPostRequest;
use App\Services\SavedPostService;
use Illuminate\Http\Request;

class SavedPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $savedPostService;

    public function __construct(SavedPostService $savedPostService)
    {
        $this->savedPostService = $savedPostService;
        $this->middleware('auth');
    }

    public function index()
    {
        $savedPosts = $this->savedPostService->getSavedPostsByUser();
        return view('saved-posts.index', compact('savedPosts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id'
        ]);
        
        $this->savedPostService->savePost($request->post_id);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Post saved successfully.');
    }

    public function destroy($postId)
    {
        $this->savedPostService->unsavePost($postId);
        
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Post unsaved.');
    }
}

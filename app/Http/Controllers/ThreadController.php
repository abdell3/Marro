<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Services\ThreadService;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $threadService;

    public function __construct(ThreadService $threadService)
     {
         $this->threadService = $threadService;
     }


    public function index()
    {
        $threads = $this->threadService->getAllThreads();
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreThreadRequest $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'community_id' => 'required|exists:communities,id',
        ]);

        $this->threadService->createThread($data);
        return redirect()->route('threads.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $thread = $this->threadService->getThreadById($id);
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThreadRequest $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'community_id' => 'required|exists:communities,id',
        ]);

        $this->threadService->updateThread($id, $data);
        return redirect()->route('threads.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->threadService->deleteThread($id);
        return redirect()->route('threads.index');
    }
}

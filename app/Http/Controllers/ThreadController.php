<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Services\ThreadService;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $threadService;

     public function __construct(ThreadService $threadService)
     {
         $this->threadService = $threadService;
         $this->middleware('auth')->except(['index', 'show']);
     }
 
     public function index(Request $request)
     {
         if ($request->has('community_id')) {
             $threads = $this->threadService->getThreadsByCommunity($request->community_id);
         } else {
             $threads = $this->threadService->getAllThreads();
         }
 
         return view('threads.index', compact('threads'));
     }
 
     public function create()
     {
         return view('threads.create');
     }
 
     public function store(StoreThreadRequest $request)
     {
         $thread = $this->threadService->createThread($request->validated());
         return redirect()->route('threads.show', $thread->id)->with('success', 'Thread created successfully.');
     }
 
     public function show($id)
     {
         $thread = $this->threadService->getThreadById($id);
         return view('threads.show', compact('thread'));
     }
 
     public function edit($id)
     {
         $thread = $this->threadService->getThreadById($id);
         $this->authorize('update', $thread);
         return view('threads.edit', compact('thread'));
     }
 
     public function update(UpdateThreadRequest $request, $id)
     {
         $thread = $this->threadService->getThreadById($id);
         $this->authorize('update', $thread);
         $this->threadService->updateThread($id, $request->validated());
         return redirect()->route('threads.show', $id)->with('success', 'Thread updated successfully.');
     }
 
     public function destroy($id)
     {
         $thread = $this->threadService->getThreadById($id);
         $this->authorize('delete', $thread);
         $this->threadService->deleteThread($id);
         return redirect()->route('threads.index')->with('success', 'Thread deleted successfully.');
     }
}

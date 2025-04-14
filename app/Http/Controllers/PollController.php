<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Models\PollOption;
use App\Services\PollService;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     protected $pollService;

    public function __construct(PollService $pollService)
    {
        $this->pollService = $pollService;
        $this->middleware('auth')->except(['show']);
    }

    public function show($id)
    {
        $poll = $this->pollService->getPollById($id);
        return view('polls.show', compact('poll'));
    }

    public function store(StorePollRequest $request)
    {
        $poll = $this->pollService->createPoll(
            $request->post_id,
            $request->question,
            $request->options,
            $request->expires_at
        );
        
        return redirect()->route('posts.show', $request->post_id)
            ->with('success', 'Poll created successfully.');
    }

    public function vote(VotePollRequest $request, $id)
    {
        $option = PollOption::findOrFail($request->option_id);
        $poll = $option->poll;
        
        
        $hasVoted = $poll->options()->whereHas('voters', function ($query) {
            $query->where('user_id', Auth::id());
        })->exists();
        
        if (!$hasVoted) {
            $option->voters()->attach(Auth::id());
            $option->increment('votes');
            return redirect()->back()->with('success', 'Vote recorded successfully.');
        }
        
        return redirect()->back()->with('nope', 'You have already voted on this poll.');
    }

    public function results($id)
    {
        $poll = $this->pollService->getPollById($id);
        return view('polls.results', compact('poll'));
    }

}

<?php

namespace App\Services;

use App\Models\PollOption;
use App\Repositories\Interfaces\PollRepositoryInterface;

class PollService
{
    /**
     * Create a new class instance.
     */
    protected $pollRepository;

    public function __construct(PollRepositoryInterface $pollRepository)
    {
        $this->pollRepository = $pollRepository;
    }

    public function getAllPolls()
    {
        return $this->pollRepository->paginate(5);
    }

    public function getPollById($id)
    {
        return $this->pollRepository->findWithOptions($id);
    }

    public function getPollByPost($postId)
    {
        return $this->pollRepository->findByPost($postId);
    }

    public function createPoll($postId, $question, $options, $expiresAt = null)
    {
        $pollData = [
            'post_id' => $postId,
            'question' => $question,
            'expires_at' => $expiresAt
        ];
        
        return $this->pollRepository->createPollWithOptions($pollData, $options);
    }

    public function updatePoll($id, array $data)
    {
        return $this->pollRepository->update($id, $data);
    }

    public function deletePoll($id)
    {
        return $this->pollRepository->delete($id);
    }

    public function voteOnOption($optionId, $userId)
    {
        $option = PollOption::findOrFail($optionId);
        $poll = $option->poll;
        
        
        $hasVoted = $poll->options()->whereHas('voters', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->exists();
        
        if (!$hasVoted) {
            $option->voters()->attach($userId);
            $option->increment('votes');
            return true;
        }
        
        return false;
    }
}

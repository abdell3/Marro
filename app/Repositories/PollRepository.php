<?php

namespace App\Repositories;

use App\Models\Poll;
use App\Models\PollOption;
use App\Repositories\Interfaces\PollRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PollRepository extends BaseRepository implements PollRepositoryInterface
{
    /**
     * Create a new class instance.
     */


    

    public function __construct(Poll $model)
    {
        parent::__construct($model);
    }

    public function findByPost($postId)
    {
        return $this->model->where('post_id', $postId)->first();
    }

    public function findWithOptions($id)
    {
        return $this->model->with('options')->findOrFail($id);
    }

    public function createPollWithOptions($pollData, $optionsData)
    {
        return DB::transaction(function () use ($pollData, $optionsData) {
            $poll = $this->model->create($pollData);
            
            foreach ($optionsData as $optionText) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'text' => $optionText,
                    'votes' => 0
                ]);
            }
            
            return $poll;
        });
    }
}

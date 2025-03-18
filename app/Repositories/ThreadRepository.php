<?php

namespace App\Repositories;

use App\Models\Thread;
use App\Repositories\Interfaces\ThreadRepositoryInterface;

class ThreadRepository implements ThreadRepositoryInterface
{
    protected $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    public function all()
    {
        return $this->thread->all();
    }

    public function find($id)
    {
        return $this->thread->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->thread->create($data);
    }

    public function update($id, array $data)
    {
        $thread = $this->thread->findOrFail($id);
        $thread->update($data);
        return $thread;
    }

    public function delete($id)
    {
        $thread = $this->thread->findOrFail($id);
        $thread->delete();
        return $thread;
    }
}

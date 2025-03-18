<?php

namespace App\Services;

use App\Repositories\Interfaces\ThreadRepositoryInterface;

class ThreadService
{
    /**
     * Create a new class instance.
     */
    protected $threadRepository;

    public function __construct(ThreadRepositoryInterface $threadRepository)
    {
        $this->threadRepository = $threadRepository;
    }

    public function getAllThreads()
    {
        return $this->threadRepository->all();
    }

    public function getThreadById($id)
    {
        return $this->threadRepository->find($id);
    }

    public function createThread(array $data)
    {
        return $this->threadRepository->create($data);
    }

    public function updateThread($id, array $data)
    {
        return $this->threadRepository->update($id, $data);
    }

    public function deleteThread($id)
    {
        return $this->threadRepository->delete($id);
    }

}

<?php

namespace App\Repositories\Interfaces;

interface PollRepositoryInterface extends RepositoryInterface
{
    public function findByPost($postId);
    public function findWithOptions($id);
    public function createPollWithOptions($pollData, $optionsData);
}

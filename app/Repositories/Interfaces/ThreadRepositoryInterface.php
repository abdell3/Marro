<?php

namespace App\Repositories\Interfaces;

interface ThreadRepositoryInterface extends RepositoryInterface
{
    public function findByCommunity($communityId);
}

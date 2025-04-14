<?php

namespace App\Repositories\Interfaces;

interface CommunityRepositoryInterface extends RepositoryInterface
{
    public function findBySlug($slug);
    public function findPopular();
    public function search($query);
}

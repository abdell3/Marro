<?php

namespace App\Repositories\Interfaces;

interface BadgeRepositoryInterface extends RepositoryInterface
{
    public function findByName($name);
    public function findWithUsers($id);
    public function attachToUser($badgeId, $userId);
    public function detachFromUser($badgeId, $userId);
}

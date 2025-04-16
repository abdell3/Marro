<?php

namespace App\Repositories\Interfaces;

interface TagRepositoryInterface extends RepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function findBySlug($slug);
    public function findByName($name);
    public function findOrCreateByName($name);
}

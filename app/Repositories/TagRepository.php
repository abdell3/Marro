<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface

{
    /**
     * Create a new class instance.
     */
    protected $tag;

    

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function all()
    {
        return $this->tag->all();
    }

    public function find($id)
    {
        return $this->tag->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->tag->create($data);
    }

    public function update($id, array $data)
    {
        $tag = $this->tag->findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        $tag = $this->tag->findOrFail($id);
        $tag->delete();
        return $tag;
    }
}


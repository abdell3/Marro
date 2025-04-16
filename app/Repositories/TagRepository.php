<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Support\Str;

class TagRepository extends BaseRepository implements TagRepositoryInterface

{
    /**
     * Create a new class instance.
     */
    // protected $model;

    public function __construct(Tag $model)
    {
        parent::__construct($model);
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function findOrCreateByName($name)
    {
        $tag = $this->findByName($name);
        
        if (!$tag) {
            $tag = $this->model->create([
                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        }
        
        return $tag;
    }
}


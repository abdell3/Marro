<?php


namespace App\Services;

use App\Repositories\Interfaces\TagRepositoryInterface;
use Illuminate\Support\Str;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        return $this->tagRepository->paginate(10);
    }

    public function getTagById($id)
    {
        return $this->tagRepository->find($id);
    }

    public function getTagBySlug($slug)
    {
        return $this->tagRepository->findBySlug($slug);
    }

    public function createTag(array $data)
    {
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        return $this->tagRepository->create($data);
    }

    public function updateTag($id, array $data)
    {
        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        
        return $this->tagRepository->update($id, $data);
    }

    public function deleteTag($id)
    {
        return $this->tagRepository->delete($id);
    }

    public function findOrCreateTag($name)
    {
        return $this->tagRepository->findOrCreateByName($name);
    }

    public function getPostsByTag($tagId)
    {
        $tag = $this->tagRepository->find($tagId);
        return $tag->posts()->paginate(15);
    }
}
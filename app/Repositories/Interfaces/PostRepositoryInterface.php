<?php

namespace App\Repositories\Interfaces;


use Illuminate\Pagination\LengthAwarePaginator ;

interface PostRepositoryInterface
{
    public function allPosts();
    public function findPost($id);
    public function createPost(array $data);
    public function updatePost($id, array $data);
    public function deletePost($id);

    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function withRelations(array $relations);
    public function filterByCommunity(int $communityId);
    public function filterByTag(int $tagId);
    // public function orderBy(string $column, string $direction = 'asc');
}

<?php

namespace App\Repositories\Interfaces;


use Illuminate\Pagination\LengthAwarePaginator ;

interface PostRepositoryInterface extends RepositoryInterface
{

    public function findByCommunity($communityId);
    public function findByUser($userId);
    public function findPopular();
    public function search($query);

    // public function paginate(int $perPage = 15): LengthAwarePaginator;
    // public function withRelations(array $relations);
    // public function filterByCommunity(int $communityId);
    // public function filterByTag(int $tagId);
    // // public function orderBy(string $column, string $direction = 'asc');
}

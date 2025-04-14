<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface
{
    public function all();
    public function paginate(int $perPage = 15);
    public function findById(int $id);
    public function findByName(string $name);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getPermissions(int $roleId);
    public function syncPermissions(int $roleId, array $permissionIds);
    public function assignToUser(int $userId, int $roleId);
    public function revokeFromUser(int $userId);
    public function getUsersWithRole(int $roleId);
    public function countUsersWithRole(int $roleId);
    public function getDefaultRole();
    public function assignDefaultRole(int $userId);
    public function search(string $query, int $perPage = 15);
}

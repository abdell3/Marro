<?php

namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function findByName(string $name);
    public function getByIds(array $ids);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getPermissionsForRole(int $roleId);
    public function syncRolePermissions(int $roleId, array $permissionIds);
    public function getDirectPermissions(int $userId);
    public function getPermissionsViaRoles(int $userId);
    public function getAllUserPermissions(int $userId);
}

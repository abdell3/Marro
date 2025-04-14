<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class PermissionService
{
    /**
     * Create a new class instance.
     */
    protected $permissionRepo;
    protected $roleRepo;

    public function __construct(
        PermissionRepositoryInterface $permissionRepo,
        RoleRepositoryInterface $roleRepo
    ) {
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo = $roleRepo;
    }

    public function getAllPermissions()
    {
        return $this->permissionRepo->all();
    }

    public function createPermission(array $data)
    {
        return $this->permissionRepo->create($data);
    }

    public function assignPermissionsToRole(int $roleId, array $permissionIds)
    {
        $validPermissions = $this->validatePermissionIds($permissionIds);
        $this->permissionRepo->syncRolePermissions($roleId, $validPermissions);
    }

    public function getUserPermissions(int $userId)
    {
        return $this->permissionRepo->getAllUserPermissions($userId);
    }

    public function userHasPermission(int $userId, string $permissionName)
    {
        return $this->getUserPermissions($userId)
            ->contains('name', $permissionName);
    }

    protected function validatePermissionIds(array $permissionIds)
    {
        $existingPermissions = $this->permissionRepo->getByIds($permissionIds);
        return $existingPermissions->pluck('id')->toArray();
    }
}

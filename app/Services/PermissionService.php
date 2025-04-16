<?php

namespace App\Services;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class PermissionService
{
    /**
     * Create a new class instance.
     */

    protected $permissionRepository;
     
    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
             $this->permissionRepository = $permissionRepository;
    }
     
    public function getAllPermissions()
    {
             return $this->permissionRepository->all();
    }
     
    public function getPermissionById($id)
    {
             return $this->permissionRepository->find($id);
    }
     
    public function getPermissionByName($name)
         {
             return $this->permissionRepository->findByName($name);
         }
     
         public function createPermission(array $data)
    {
             return $this->permissionRepository->create($data);
    }
     
    public function updatePermission($id, array $data)
    {
             return $this->permissionRepository->update($id, $data);
    }
     
    public function deletePermission($id)
    {
             return $this->permissionRepository->delete($id);
    }
}


    // protected $permissionRepo;
    // protected $roleRepo;

    // public function __construct(
    //     PermissionRepositoryInterface $permissionRepo,
    //     RoleRepositoryInterface $roleRepo
    // ) {
    //     $this->permissionRepo = $permissionRepo;
    //     $this->roleRepo = $roleRepo;
    // }

    // public function getAllPermissions()
    // {
    //     return $this->permissionRepo->all();
    // }

    // public function createPermission(array $data)
    // {
    //     return $this->permissionRepo->create($data);
    // }

    // public function assignPermissionsToRole(int $roleId, array $permissionIds)
    // {
    //     $validPermissions = $this->validatePermissionIds($permissionIds);
    //     $this->permissionRepo->syncRolePermissions($roleId, $validPermissions);
    // }

    // public function getUserPermissions(int $userId)
    // {
    //     return $this->permissionRepo->getAllUserPermissions($userId);
    // }

    // public function userHasPermission(int $userId, string $permissionName)
    // {
    //     return $this->getUserPermissions($userId)
    //         ->contains('name', $permissionName);
    // }

    // protected function validatePermissionIds(array $permissionIds)
    // {
    //     $existingPermissions = $this->permissionRepo->getByIds($permissionIds);
    //     return $existingPermissions->pluck('id')->toArray();
    // }


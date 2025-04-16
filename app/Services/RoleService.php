<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\RoleRepository;

class RoleService
{
    /**
     * Create a new class instance.
     */


     protected $roleRepository;

     public function __construct(RoleRepositoryInterface $roleRepository)
     {
         $this->roleRepository = $roleRepository;
     }
 
     public function getAllRoles()
     {
         return $this->roleRepository->all();
     }
 
     public function getRoleById($id)
     {
         return $this->roleRepository->findWithPermissions($id);
     }
 
     public function getRoleByName($name)
     {
         return $this->roleRepository->findByName($name);
     }
 
     public function createRole(array $data)
     {
         return $this->roleRepository->create($data);
     }
 
     public function updateRole($id, array $data)
     {
         return $this->roleRepository->update($id, $data);
     }
 
     public function deleteRole($id)
     {
         return $this->roleRepository->delete($id);
     }
 
     public function assignPermissions($roleId, $permissionIds)
     {
         return $this->roleRepository->syncPermissions($roleId, $permissionIds);
     }
 
     public function assignRoleToUser($userId, $roleId)
     {
         $user = User::findOrFail($userId);
         return $user->roles()->sync([$roleId], false);
     }
 
     public function removeRoleFromUser($userId, $roleId)
     {
         $user = User::findOrFail($userId);
         return $user->roles()->detach($roleId);
     }


    // protected $roleRepo;
    // protected $permissionRepo;

    // public function __construct(
    //     RoleRepositoryInterface $roleRepo,
    //     PermissionRepositoryInterface $permissionRepo
    // ) {
    //     $this->roleRepo = $roleRepo;
    //     $this->permissionRepo = $permissionRepo;
    // }

    // public function getAllRoles()
    // {
    //     return $this->roleRepo->all();
    // }

    // public function getPaginatedRoles(int $perPage = 15)
    // {
    //     return $this->roleRepo->paginate($perPage);
    // }

    // public function createRole(array $data)
    // {
    //     return $this->roleRepo->create($data);
    // }

    // public function updateRole(int $id, array $data)
    // {
    //     return $this->roleRepo->update($id, $data);
    // }

    // public function deleteRole(int $id)
    // {
    //     return $this->roleRepo->delete($id);
    // }

    // public function assignPermissions(int $roleId, array $permissionIds)
    // {
    //     $validPermissions = $this->permissionRepo->getByIds($permissionIds);
    //     $this->roleRepo->syncPermissions($roleId, $validPermissions->pluck('id')->toArray());
    // }

    // public function assignRoleToUser(int $userId, int $roleId)
    // {
    //     return $this->roleRepo->assignToUser($userId, $roleId);
    // }

    // public function revokeRoleFromUser(int $userId)
    // {
    //     return $this->roleRepo->revokeFromUser($userId);
    // }

    // public function searchRoles(string $query, int $perPage = 15)
    // {
    //     return $this->roleRepo->search($query, $perPage);
    // }
}

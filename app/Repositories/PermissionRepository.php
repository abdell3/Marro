<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\User;
use App\Models\Role;
use App\Repositories\Interfaces\PermissionRepositoryInterface;



class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected $model;

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    // public function __construct(Permission $permission)
    // {
    //     $this->model = $permission;
    // }


    // public function all()
    // {
    //     return $this->model->all();
    // }

    // public function findById(int $id)
    // {
    //     return $this->model->findOrFail($id);
    // }

    // public function findByName(string $name)
    // {
    //     return $this->model->where('name', $name)->firstOrFail();
    // }

    // public function getByIds(array $ids)
    // {
    //     return $this->model->whereIn('id', $ids)->get();
    // }

    // public function create(array $data)
    // {
    //     return $this->model->create($data);
    // }

    // public function update(int $id, array $data)
    // {
    //     $permission = $this->findById($id);
    //     $permission->update($data);
    //     return $permission;
    // }

    // public function delete(int $id)
    // {
    //     $permission = $this->findById($id);
    //     return $permission->delete();
    // }

    // public function getPermissionsForRole(int $roleId)
    // {
    //     return Role::findOrFail($roleId)->permissions;
    // }

    // public function syncRolePermissions(int $roleId, array $permissionIds): void
    // {
    //     $role = Role::findOrFail($roleId);
    //     $role->permissions()->sync($permissionIds);
    // }

    // public function getDirectPermissions(int $userId)
    // {
    //     return User::findOrFail($userId)->permissions;
    // }

    // public function getPermissionsViaRoles(int $userId)
    // {
    //     return User::findOrFail($userId)->getPermissionsViaRoles();
    // }

    // public function getAllUserPermissions(int $userId)
    // {
    //     $user = User::findOrFail($userId);
    //     return $user->getAllPermissions();
    // }


}

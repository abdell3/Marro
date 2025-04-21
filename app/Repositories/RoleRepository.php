<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }

    public function findWithPermissions($id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }

    public function attachPermissions($roleId, $permissionIds)
    {
        $role = $this->find($roleId);
        return $role->permissions()->attach($permissionIds);
    }

    public function detachPermissions($roleId, $permissionIds)
    {
        $role = $this->find($roleId);
        return $role->permissions()->detach($permissionIds);
    }

    public function syncPermissions($roleId, $permissionIds)
    {
        $role = $this->find($roleId);
        return $role->permissions()->sync($permissionIds);
    }

    public function withCount()
    {
        return Role::withCount('users')->get();
    }

}

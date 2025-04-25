<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    /**
     * Find role by name
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->model->where('role_name', $name)->first();
    }

    /**
     * Assign permission to role
     * @param int $roleId
     * @param int $permissionId
     * @return mixed
     */
    public function assignPermission(int $roleId, int $permissionId)
    {
        $role = $this->find($roleId);
        return $role->permissions()->attach($permissionId);
    }

    /**
     * Remove permission from role
     * @param int $roleId
     * @param int $permissionId
     * @return mixed
     */
    public function removePermission(int $roleId, int $permissionId)
    {
        $role = $this->find($roleId);
        return $role->permissions()->detach($permissionId);
    }

    /**
     * Get all permissions for role
     * @param int $roleId
     * @return mixed
     */
    public function getPermissions(int $roleId)
    {
        $role = $this->find($roleId);
        return $role->permissions;
    }
}

<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * PermissionRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    /**
     * Find permission by name
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }

    /**
     * Get all roles for permission
     * @param int $permissionId
     * @return mixed
     */
    public function getRoles(int $permissionId)
    {
        $permission = $this->find($permissionId);
        return $permission->roles;
    }
}

<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find role by name
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name);

    /**
     * Assign permission to role
     * @param int $roleId
     * @param int $permissionId
     * @return mixed
     */
    public function assignPermission(int $roleId, int $permissionId);

    /**
     * Remove permission from role
     * @param int $roleId
     * @param int $permissionId
     * @return mixed
     */
    public function removePermission(int $roleId, int $permissionId);

    /**
     * Get all permissions for role
     * @param int $roleId
     * @return mixed
     */
    public function getPermissions(int $roleId);
}

<?php

namespace App\Repositories\Interfaces;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find permission by name
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name);

    /**
     * Get all roles for permission
     * @param int $permissionId
     * @return mixed
     */
    public function getRoles(int $permissionId);
}

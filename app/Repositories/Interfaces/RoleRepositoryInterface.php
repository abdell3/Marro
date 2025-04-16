<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface extends RepositoryInterface
{
    public function findByName($name);
    public function findWithPermissions($id);
    public function attachPermissions($roleId, $permissionIds);
    public function detachPermissions($roleId, $permissionIds);
    public function syncPermissions($roleId, $permissionIds);
}

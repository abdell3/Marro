<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->with('permissions')->paginate($perPage);
    }

    public function findById(int $id)
    {
        return $this->model->with('permissions')->findOrFail($id);
    }

    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $role = $this->findById($id);
        $role->update($data);
        return $role;
    }

    public function delete(int $id)
    {
        $role = $this->findById($id);
        return $role->delete();
    }

    public function getPermissions(int $roleId)
    {
        return $this->findById($roleId)->permissions;
    }

    public function syncPermissions(int $roleId, array $permissionIds)
    {
        $role = $this->findById($roleId);
        $role->permissions()->sync($permissionIds);
    }

    public function assignToUser(int $userId, int $roleId)
    {
        $user = User::findOrFail($userId);
        $user->role_id = $roleId;
        return $user->save();
    }

    public function revokeFromUser(int $userId)
    {
        $defaultRole = $this->getDefaultRole();
        return $this->assignToUser($userId, $defaultRole->id);
    }

    public function getUsersWithRole(int $roleId)
    {
        return User::where('role_id', $roleId)->get();
    }

    public function countUsersWithRole(int $roleId)
    {
        return User::where('role_id', $roleId)->count();
    }

    public function getDefaultRole()
    {
        return $this->model->where('name', 'user')->firstOrFail();
    }

    public function assignDefaultRole(int $userId)
    {
        $defaultRole = $this->getDefaultRole();
        return $this->assignToUser($userId, $defaultRole->id);
    }

    public function search(string $query, int $perPage = 15)
    {
        return $this->model
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('permissions')
            ->paginate($perPage);
    }


}

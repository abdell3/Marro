<?php


namespace App\Traits;

use App\Models\Permission;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public function hasRole(...$roles)
    {
        return $this->roles->whereIn('slug', $roles)->isNotEmpty();
    }

    public function hasPermission($permission)
    {
        return Cache::remember("user.{$this->id}.permissions", now()->addDay(), function() {
            return $this->permissions->pluck('slug')
                ->merge($this->roles->flatMap->permissions->pluck('slug'))
                ->unique();
        })->contains($permission);
    }

    public function givePermissionsTo(array $permissions)
    {
        $this->permissions()->attach($this->resolvePermissionIds($permissions));
    }

    protected function permissionIds(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }
}
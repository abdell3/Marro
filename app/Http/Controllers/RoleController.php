<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\http\Middleware\CheckPermission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $roleService;
     protected $permissionService;
 
     public function __construct(RoleService $roleService, PermissionService $permissionService)
     {
         $this->roleService = $roleService;
         $this->permissionService = $permissionService;
         $this->middleware('auth');
         $this->middleware('can:admin');
     }
 
     public function index()
     {
         $roles = $this->roleService->getAllRoles();
         return view('admin.roles.index', compact('roles'));
     }
 
     public function create()
     {
         $permissions = $this->permissionService->getAllPermissions();
         return view('admin.roles.create', compact('permissions'));
     }
 
     public function store(StoreRoleRequest $request)
     {
         $role = $this->roleService->createRole($request->only(['name', 'description']));
         
         if ($request->has('permissions')) {
             $this->roleService->assignPermissions($role->id, $request->permissions);
         }
         
         return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
     }
 
     public function show($id)
     {
         $role = $this->roleService->getRoleById($id);
         return view('admin.roles.show', compact('role'));
     }
 
     public function edit($id)
     {
         $role = $this->roleService->getRoleById($id);
         $permissions = $this->permissionService->getAllPermissions();
         return view('admin.roles.edit', compact('role', 'permissions'));
     }
 
     public function update(UpdateRoleRequest $request, $id)
     {
         $this->roleService->updateRole($id, $request->only(['name', 'description']));
         
         if ($request->has('permissions')) {
             $this->roleService->assignPermissions($id, $request->permissions);
         }
         
         return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
     }
 
     public function destroy($id)
     {
         $this->roleService->deleteRole($id);
         return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
     }
}

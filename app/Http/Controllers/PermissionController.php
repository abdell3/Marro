<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    protected $permissionService;
    protected $roleService;

    public function __construct(PermissionService $permissionService, RoleService $roleService)
    {
         $this->roleService = $roleService; 
         $this->permissionService = $permissionService;
         $this->middleware('auth');
         $this->middleware('can:admin');
    }
 
    public function index()
    {
         $permissions = $this->permissionService->getAllPermissions();
         return view('admin.permissions.index', compact('permissions'));
    }
 
    public function create()
    {
         $this->roleService->getAllRoles();
         return view('admin.permissions.create');
    }
 
    public function store(StorePermissionRequest $request)
    {
         $this->permissionService->createPermission($request->validated());

         if($request->has('roles'))
         {
             $this->roleService->assignPermissions($request->roles, $request->permissions); 
         }
         return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }
 
    public function show($id)
    {
         $permission = $this->permissionService->getPermissionById($id);
         return view('admin.permissions.show', compact('permission'));
    }
 
    public function edit($id)
    {
         $permission = $this->permissionService->getPermissionById($id);
         $roles = $this->roleService->getAllRoles();
         return view('admin.permissions.edit', compact('permission', 'roles'));
    }
 
    public function update(UpdatePermissionRequest $request, $id)
    {
         $this->permissionService->updatePermission($id, $request->validated());
         return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }
 
    public function destroy($id)
    {
         $this->permissionService->deletePermission($id);
         return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }

}
    // protected $permissionService;

    // public function __construct(PermissionService $permissionService)
    //  {
    //     //  $this->middleware('can:manage_permissions');
    //      $this->permissionService = $permissionService;
    //  }


    // public function index()
    // {
    //     $permissions = $this->permissionService->getAllPermissions();
    //     return response()->json($permissions);
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(StorePermissionRequest $request)
    // {
    //     $permission = $this->permissionService->createPermission($request->validated());
        
    //     return response()->json([
    //         'message' => 'Permission created successfully',
    //         'permission' => $permission
    //     ], 201);
    // }


    // public function assignToRole(Request $request, $roleId)
    // {
    //     $validated = $request->validate([
    //         'permissions' => 'required|array',
    //         'permissions.*' => 'exists:permissions,id'
    //     ]);

    //     $this->permissionService->assignPermissionsToRole(
    //         $roleId,
    //         $validated['permissions']
    //     );

    //     return response()->json([
    //         'message' => 'Permissions assigned to role successfully'
    //     ]);
    // }



    // /**
    //  * Display the specified resource.
    //  */
    // public function show(Permission $permission)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(Permission $permission)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(UpdatePermissionRequest $request, Permission $permission)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Permission $permission)
    // {
    //     //
    // }


<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    protected $permissionService;

    public function __construct(PermissionService $permissionService)
     {
        //  $this->middleware('can:manage_permissions');
         $this->permissionService = $permissionService;
     }


    public function index()
    {
        $permissions = $this->permissionService->getAllPermissions();
        return response()->json($permissions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionService->createPermission($request->validated());
        
        return response()->json([
            'message' => 'Permission created successfully',
            'permission' => $permission
        ], 201);
    }


    public function assignToRole(Request $request, $roleId)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $this->permissionService->assignPermissionsToRole(
            $roleId,
            $validated['permissions']
        );

        return response()->json([
            'message' => 'Permissions assigned to role successfully'
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}

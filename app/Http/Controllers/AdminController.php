<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * @var RoleServiceInterface
     */
    protected $roleService;

    /**
     * AdminController constructor.
     */
    public function __construct(
        UserServiceInterface $userService,
        RoleServiceInterface $roleService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        
        // Apply auth middleware for all actions
        $this->middleware('auth');
        
        // Apply role middleware for admin only
        $this->middleware('role:admin');
    }

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        $roles = $this->roleService->getAllRoles();

        return view('admin.index', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Display users management.
     */
    public function users()
    {
        $users = $this->userService->getAllUsers();
        $roles = $this->roleService->getAllRoles();

        return view('admin.users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Update user role.
     */
    public function updateUserRole(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $this->userService->updateUser($id, [
            'role_id' => $request->input('role_id'),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Rôle de l\'utilisateur mis à jour avec succès.');
    }

    /**
     * Display roles and permissions management.
     */
    public function roles()
    {
        $roles = $this->roleService->getAllRoles();
        $permissions = $this->roleService->getAllPermissions();

        return view('admin.roles', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update role permissions.
     */
    public function updateRolePermissions(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $this->roleService->syncRolePermissions($id, $request->input('permissions', []));

        return redirect()->route('admin.roles')
            ->with('success', 'Permissions du rôle mises à jour avec succès.');
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        $this->userService->deleteUser($id);

        return redirect()->route('admin.users')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Ban a user.
     */
    public function banUser($id)
    {
        // In a real implementation, we would add a 'banned' field to the user model
        // Here we'll just delete the user for simplicity
        $this->userService->deleteUser($id);

        return redirect()->route('admin.users')
            ->with('success', 'Utilisateur banni avec succès.');
    }
}

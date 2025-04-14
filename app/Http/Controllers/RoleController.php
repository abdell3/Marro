<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\http\Middleware\CheckPermission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $checkPermission;

    
     public function __construct(CheckPermission $checkPermission)
     {
        $this->checkPermission = $checkPermission;
         
        // $this->middleware('auth')->except(['index', 'show']);
     }
    
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        return view('admin.roles.index', ['roles' => Role::with('permissions')->get()]);
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
    public function store(StoreRoleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}

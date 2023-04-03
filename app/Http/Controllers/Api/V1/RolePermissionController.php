<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Role $role)
    {
        //
        $permissions = $role->getAllPermissions();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Role $role, Permission $permission)
    {
        if ($role->hasPermission($permission)) {
            // return permission already not exist
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, Permission $permission)
    {
        if ($role->hasPermission($permission)) {
        }

        // return permission does not exist
    }
}

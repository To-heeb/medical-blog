<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        //
        $permissions = $user->getAllPermissions();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, Permission $permission)
    {
        if ($user->hasPermission($permission)) {
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
    public function destroy(User $user, Permission $permission)
    {
        if ($user->hasPermission($permission)) {
        }

        // return permission does not exist
    }
}

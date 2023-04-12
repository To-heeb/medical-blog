<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionCollection;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Role $role)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $permissions = $role->getAllPermissions();

        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Role $role)
    {

        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string', Rule::unique('permissions', 'name')],
        ]);

        if ($role->hasPermissionTo($validated['name'])) {
            // return permission already exist
            return ApiResponse->error(Response::HTTP_CONFLICT, 'Permission already exists');
        }

        $permission = $role->givePermissionTo($validated['name']);

        return new PermissionResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, Permission $permission)
    {

        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        if ($role->hasPermissionTo($permission)) {

            $permission = $role->revokePermissionTo($permission);

            return new PermissionResource($permission);
        }

        // return permission does not exist
        return ApiResponse->error(Response::HTTP_CONFLICT, "Permission doesn't exists");
    }
}

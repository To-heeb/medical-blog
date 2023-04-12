<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionCollection;

class UserPermissionController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $permissions = $user->getAllPermissions();

        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {

        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string', Rule::unique('permissions', 'name')],
        ]);

        if ($user->hasPermission($validated['name'])) {
            // return permission already exist
            return ApiResponse->error(Response::HTTP_CONFLICT, 'Permission already exists');
        }

        $permission = $user->givePermissionTo($validated['name']);

        return new PermissionResource($permission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Permission $permission)
    {

        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        if ($user->hasPermission($permission)) {

            $permission = $user->revokePermissionTo($permission);

            return new PermissionResource($permission);
        }

        // return permission does not exist
        return ApiResponse->error(Response::HTTP_CONFLICT, "Permission doesn't exists");
    }
}

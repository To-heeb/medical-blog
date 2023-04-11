<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        #$this->authorize('view-any', Role::class);

        $roles = Role::whereNotIn('name', ['super-admin'])->get();

        return new RoleResource($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        #$this->authorize('create', Role::class);

        $validated = $request->validated();

        $role = Role::create($validated);

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        #$this->authorize('view', $role);
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }


        return new RoleResource($role);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        #$this->authorize('update', $role);
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }


        $validated = $request->validated();

        $role->update($validated);

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        #$this->authorize('delete', $role);
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $role->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $roles = Role::latest('created_at')->get();

        return RoleResource::collection($roles);
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
    public function store(CreateRoleRequest $request): RoleResource
    {
        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);

        $role->syncPermissions($request->input('permissions'));

        return RoleResource::make($role);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): RoleResource
    {
        $role->load('permissions');

        return RoleResource::make($role);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role): RoleResource
    {
        $role->update(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permissions'));

        $users = User::where('is_admin', false)->get();

        $users->each(function ($user) {$user->tokens()->delete();});

        return RoleResource::make($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): JsonResource
    {
        Role::where('id', $role->id)->delete();

        return JsonResource::make(['id' => $role->id]);
    }
}

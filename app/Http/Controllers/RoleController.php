<?php

namespace App\Http\Controllers;

use App\Enums\Ability;
use App\Http\Requests\Role\CreateRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/role/Index', [
            'roles' => Role::all(),
        ]);
    }

    public function create()
    {
        Gate::authorize(Ability::CREATE, Role::class);

        return Inertia::render('auth/role/Create', [
            'permissions' => Permission::all()->pluck('name'),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        $permissions = Permission::whereIn('name', $request->input('permissions'))->get();

        $role->permissions()->sync($permissions);

        return redirect()->route('roles.index');
    }

    public function edit(Role $role)
    {
        Gate::authorize(Ability::UPDATE, $role);

        $role->load('permissions');

        return Inertia::render('auth/role/Edit', [
            'role' => $role,
            'permissions' => Permission::all()->pluck('name'),
        ]);
    }

    public function update(UpdateRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->input('name'),
        ]);

        $permissions = Permission::whereIn('name', $request->input('permissions'))->get();

        $role->permissions()->sync($permissions);

        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        Gate::authorize(Ability::DELETE, $role);

        $role->delete();

        return redirect()->route('roles.index');
    }
}

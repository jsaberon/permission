<?php

namespace App\Http\Controllers;

use App\Enums\Ability;
use App\Http\Requests\Permission\CreateRequest;
use App\Http\Requests\Permission\UpdateRequest;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/permission/Index', [
            'permissions' => Permission::all(),
        ]);
    }

    public function create()
    {
        Gate::authorize(Ability::CREATE, Permission::class);

        return Inertia::render('auth/permission/Create');
    }

    public function store(CreateRequest $request)
    {
        Permission::create($request->all());

        return redirect()->route('permissions.index');
    }

    public function edit(Permission $permission)
    {
        Gate::authorize(Ability::UPDATE, $permission);

        return Inertia::render('auth/permission/Edit', [
            'permission' => $permission,
        ]);
    }

    public function update(UpdateRequest $request, Permission $permission)
    {
        $permission->update($request->only(['description']));

        return redirect()->route('permissions.index');
    }
}

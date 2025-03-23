<?php

namespace App\Http\Controllers;

use App\Enums\Ability;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('auth/user/Index', [
            'users' => User::get(),
        ]);
    }

    public function create()
    {
        Gate::authorize(Ability::CREATE, User::class);

        return Inertia::render('auth/user/Create', [
            'roles' => Role::get()->pluck('name'),
        ]);
    }

    public function store(CreateRequest $request)
    {
        $user = User::create($request->all());

        $roles = Role::whereIn('name', $request->input('roles'))->get();

        $user->roles()->sync($roles);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        Gate::authorize(Ability::UPDATE, $user);

        $user->load('roles');

        return Inertia::render('auth/user/Edit', [
            'user' => $user,
            'roles' => Role::get()->pluck('name'),
        ]);
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email']));

        $roles = Role::whereIn('name', $request->input('roles'))->get();

        $user->roles()->sync($roles);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        Gate::authorize(Ability::DELETE, $user);

        $user->delete();

        return redirect()->route('users.index');
    }
}

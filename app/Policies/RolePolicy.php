<?php

namespace App\Policies;

use App\Enums\RolePermission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the role can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([
            RolePermission::CREATE,
            RolePermission::UPDATE,
            RolePermission::UPDATE_ANY,
            RolePermission::DELETE,
            RolePermission::DELETE_ANY,
        ]);
    }

    /**
     * Determine whether the role can create models.
     */
    public function create(User $user): Response
    {
        if ($user->hasPermission(RolePermission::DENY_CREATE)) {
            return Response::denyAsNotFound();
        }

        return $user->hasPermission(RolePermission::CREATE) ?
            Response::allow() :
            Response::denyAsNotFound();
    }

    /**
     * Determine whether the role can update the model.
     */
    public function update(User $user, Role $role): Response
    {
        if ($user->notOwner($role)) {
            if ($user->hasPermission(RolePermission::DENY_UPDATE_ANY)) {
                return Response::denyAsNotFound();
            }

            return $user->hasPermission(RolePermission::UPDATE_ANY) ?
                Response::allow() :
                Response::denyAsNotFound();
        }

        return $user->hasPermission(RolePermission::UPDATE) ?
            Response::allow() :
            Response::denyAsNotFound();
    }

    /**
     * Determine whether the role can delete the model.
     */
    public function delete(User $user, Role $userModel): Response
    {
        if ($user->notOwner($userModel)) {
            if ($user->hasPermission(RolePermission::DENY_DELETE_ANY)) {
                return Response::denyAsNotFound();
            }

            return $user->hasPermission(RolePermission::DELETE_ANY) ?
                Response::allow() :
                Response::denyAsNotFound();
        }

        return $user->hasPermission(RolePermission::DELETE_ANY) ?
            Response::allow() :
            Response::denyAsNotFound();
    }
}

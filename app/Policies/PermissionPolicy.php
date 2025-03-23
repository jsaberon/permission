<?php

namespace App\Policies;

use App\Enums\PermissionPermission;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    /**
     * Determine whether the permission can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([
            PermissionPermission::CREATE,
            PermissionPermission::UPDATE,
            PermissionPermission::UPDATE_ANY,
        ]);
    }

    /**
     * Determine whether the permission can create models.
     */
    public function create(User $user): Response
    {
        if ($user->hasPermission(PermissionPermission::DENY_CREATE)) {
            return Response::denyAsNotFound();
        }

        return $user->hasPermission(PermissionPermission::CREATE) ?
            Response::allow() :
            Response::denyAsNotFound();
    }

    /**
     * Determine whether the permission can update the model.
     */
    public function update(User $user, Permission $permission): Response
    {
        if ($user->notOwner($permission)) {
            if ($user->hasPermission(PermissionPermission::DENY_UPDATE_ANY)) {
                return Response::denyAsNotFound();
            }

            return $user->hasPermission(PermissionPermission::UPDATE_ANY) ?
                Response::allow() :
                Response::denyAsNotFound();
        }

        return $user->hasPermission(PermissionPermission::UPDATE) ?
            Response::allow() :
            Response::denyAsNotFound();
    }
}

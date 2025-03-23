<?php

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission([
            UserPermission::CREATE,
            UserPermission::UPDATE,
            UserPermission::UPDATE_ANY,
            UserPermission::DELETE,
            UserPermission::DELETE_ANY,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->hasPermission(UserPermission::DENY_CREATE)) {
            return Response::denyAsNotFound();
        }

        return $user->hasPermission(UserPermission::CREATE) ?
            Response::allow() :
            Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $userModel): Response
    {
        if ($user->notOwner($userModel)) {
            if ($user->hasPermission(UserPermission::DENY_UPDATE_ANY)) {
                return Response::denyAsNotFound();
            }

            return $user->hasPermission(UserPermission::UPDATE_ANY) ?
                Response::allow() :
                Response::denyAsNotFound();
        }

        return $user->hasPermission(UserPermission::UPDATE) ?
            Response::allow() :
            Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $userModel): Response
    {
        if ($user->notOwner($userModel)) {
            if ($user->hasPermission(UserPermission::DENY_DELETE_ANY)) {
                return Response::denyAsNotFound();
            }

            return $user->hasPermission(UserPermission::DELETE_ANY) ?
                Response::allow() :
                Response::denyAsNotFound();
        }

        return $user->hasPermission(UserPermission::DELETE_ANY) ?
            Response::allow() :
            Response::denyAsNotFound();
    }
}

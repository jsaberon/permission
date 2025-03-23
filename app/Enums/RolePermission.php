<?php

namespace App\Enums;

enum RolePermission: string
{
    case CREATE = 'role:create';
    case UPDATE = 'role:update';
    case UPDATE_ANY = 'role:update-any';
    case DELETE = 'role:delete';
    case DELETE_ANY = 'role:delete-any';

    case DENY_CREATE = 'role:deny-create';
    case DENY_UPDATE_ANY = 'role:deny-update-any';
    case DENY_DELETE_ANY = 'role:deny-delete-any';
}

<?php

namespace App\Enums;

enum UserPermission: string
{
    case CREATE = 'user:create';
    case UPDATE = 'user:update';
    case UPDATE_ANY = 'user:update-any';
    case DELETE = 'user:delete';
    case DELETE_ANY = 'user:delete-any';

    case DENY_CREATE = 'user:deny-create';
    case DENY_UPDATE_ANY = 'user:deny-update-any';
    case DENY_DELETE_ANY = 'user:deny-delete-any';
}

<?php

namespace App\Enums;

enum PermissionPermission: string
{
    case CREATE = 'permission:create';
    case UPDATE = 'permission:update';
    case UPDATE_ANY = 'permission:update-any';

    case DENY_CREATE = 'permission:deny-create';
    case DENY_UPDATE_ANY = 'permission:deny-update-any';
}

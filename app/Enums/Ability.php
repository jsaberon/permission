<?php

namespace App\Enums;

enum Ability: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}

<?php

namespace App\Enums;

class PermissionEnum extends Enum
{
    public const DELETE_PET = 'delete-pet';
    public const UPDATE_PET = 'update-pet';
    public const UPDATE_USER = 'update-user';
    public const CREATE_USER = 'create-user';
    public const UPDATE_ADMIN = 'update-admin';
    public const DELETE_ADMIN = 'delete-admin';
}

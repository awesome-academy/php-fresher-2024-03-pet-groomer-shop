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
    public const CREATE_PET = 'create-pet';
    public const CREATE_COUPON = 'create-coupon';
    public const UPDATE_COUPON = 'update-coupon';
    public const DELETE_COUPON = 'delete-coupon';
}

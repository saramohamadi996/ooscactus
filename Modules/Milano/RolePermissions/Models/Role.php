<?php
namespace Milano\RolePermissions\Models;

class Role extends \Spatie\Permission\Models\Role
{
    const ROLE_SELLER = 'seller';
    const ROLE_SUPER_ADMIN = 'super admin';
    const ROLE_CUSTOMER = 'customer';
    static $roles = [
        self::ROLE_SELLER => [Permission::PERMISSION_SELL],
        self::ROLE_SUPER_ADMIN => [Permission::PERMISSION_SUPER_ADMIN],
        self::ROLE_CUSTOMER => []
    ];
}

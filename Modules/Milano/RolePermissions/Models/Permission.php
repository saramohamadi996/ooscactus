<?php

namespace Milano\RolePermissions\Models;
class Permission extends \Spatie\Permission\Models\Permission
{
    const PERMISSION_MANAGE_BANNERS = 'manage banners';
    const PERMISSION_MANAGE_USERS = 'manage users';
    const PERMISSION_MANAGE_ROLE_PERMISSIONS = 'manage role_permissions';
    const PERMISSION_MANAGE_CATEGORIES = 'manage categories';
    const PERMISSION_MANAGE_PRODUCTS = 'manage products';
    const PERMISSION_MANAGE_OWN_PRODUCTS = 'manage own products';
    const PERMISSION_SELL  = 'sell';
    const PERMISSION_MANAGE_ARTICLES = 'manage articles';
    const PERMISSION_MANAGE_COMMENTS = 'manage comments';
    const PERMISSION_MANAGE_COUPONS = 'manage coupons';
    const PERMISSION_MANAGE_SLIDESHOWS = 'manage slideshows';
    const PERMISSION_MANAGE_ADSS = 'manage adss';
    const PERMISSION_MANAGE_SETTINGS = 'manage settings';
    const PERMISSION_MANAGE_BANERS = 'manage baners';
    const PERMISSION_MANAGE_SELLERS = 'manage sellers';
    const PERMISSION_MANAGE_PAYMENTS = 'manage payments';

    static $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_MANAGE_BANNERS,
        self::PERMISSION_MANAGE_USERS,
        self::PERMISSION_MANAGE_ROLE_PERMISSIONS,
        self::PERMISSION_MANAGE_CATEGORIES,
        self::PERMISSION_MANAGE_PRODUCTS,
        self::PERMISSION_MANAGE_OWN_PRODUCTS,
        self::PERMISSION_SELL,
        self::PERMISSION_MANAGE_ARTICLES,
        self::PERMISSION_MANAGE_COMMENTS,
        self::PERMISSION_MANAGE_COUPONS,
        self::PERMISSION_MANAGE_SLIDESHOWS,
        self::PERMISSION_MANAGE_ADSS,
        self::PERMISSION_MANAGE_SETTINGS,
        self::PERMISSION_MANAGE_BANERS,
        self::PERMISSION_MANAGE_SELLERS,
        self::PERMISSION_MANAGE_PAYMENTS,
    ];
    const PERMISSION_SUPER_ADMIN  = 'super admin';
}

<?php

namespace Milano\Coupon\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Milano\Article\Policies\CouponPolicy;
use Milano\Coupon\Models\Coupon;
use Milano\RolePermissions\Models\Permission;

class CouponServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__. '/../Routes/coupons_routes.php');
        $this->loadViewsFrom(__DIR__. '/../Resources/Views', 'Coupons');
        $this->loadMigrationsFrom(__DIR__. '/../Database/Migrations');
        $this->loadJsonTranslationsFrom(__DIR__. '/../Resources/Lang');
        $this->loadTranslationsFrom(__DIR__. '/../Resources/Lang/', "Coupons");
        Gate::policy(Coupon::class, CouponPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.coupons', [
            "icon" => "i-discounts",
            "title" => "کد تخفیف",
            "url" => route('coupons.index'),
            'permission'=>Permission::PERMISSION_MANAGE_COUPONS
        ]);
    }
}

<?php
namespace Milano\Payment\Providers;

use App\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Milano\Payment\Gateways\Gateway;
use Milano\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Milano\RolePermissions\Models\Permission;
use Milano\User\Http\Middleware\StoreUserIp;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = "Milano\Payment\Http\Controllers";
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->loadMigrationsFrom(__DIR__ . " /../Database/Migrations");
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/payment_routes.php");
        Route::middleware("web")->namespace($this->namespace)->group(__DIR__ . "/../Routes/settlement_routes.php");
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Payment");
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        $this->app['router']->pushMiddlewareToGroup('web', StoreUserIp::class);
    }

    public function boot()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new ZarinpalAdaptor();
        });

        config()->set('sidebar.items.payments', [
            "icon" => "i-transactions",
            "title" => "تراکنش ها",
            "url" => route('payments.index'),
            "permission" => [
                Permission::PERMISSION_MANAGE_PRODUCTS,
            ]
        ]);

        config()->set('sidebar.items.my-purchases', [
            "icon" => "i-my__purchases",
            "title" => "خریدهای من",
            "url" => route('purchases.index'),
        ]);

        config()->set('sidebar.items.settlements', [
            "icon" => "i-checkouts",
            "title" => " تسویه حساب ها",
            "url" => route('settlements.index'),
//            "permission" => [
//                Permission::PERMISSION_MANAGE_COURSES,
//            ]
        ]);
        config()->set('sidebar.items.settlementsRequest', [
            "icon" => "i-checkout__request",
            "title" => "درخواست تسویه",
            "url" => route('settlements.create'),
//            "permission" => [
//                Permission::PERMISSION_MANAGE_COURSES,
//            ]
        ]);
    }
}

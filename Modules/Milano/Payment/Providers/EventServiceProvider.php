<?php
namespace Milano\Payment\Providers;
use Milano\Course\Listeners\RegisterUserInTheProduct;
use Milano\Payment\Events\PaymentWasSuccessful;
use Milano\Payment\Listeners\AddSellersShareToHisAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            AddSellersShareToHisAccount::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}

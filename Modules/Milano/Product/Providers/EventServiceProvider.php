<?php

namespace Milano\Product\Providers;

use Milano\Product\Listeners\RegisterUserInTheProduct;
use Milano\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            RegisterUserInTheProduct::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}

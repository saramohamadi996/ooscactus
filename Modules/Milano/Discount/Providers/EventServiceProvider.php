<?php

namespace Milano\Discount\Providers;

use Milano\Discount\Listeners\UpdateUsedDiscountsForPayment;
use Milano\Payment\Events\PaymentWasSuccessful;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            UpdateUsedDiscountsForPayment::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}

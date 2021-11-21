<?php

namespace Milano\Product\Listeners;

use Milano\Product\Models\Product;
use Milano\Product\Repositories\ProductRepo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterUserInTheProduct
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        if ($event->payment->paymentable_type == Product::class) {
            resolve(ProductRepo::class)->addCustomerToProduct
            ($event->payment->paymentable, $event->payment->buyer_id);
        }
    }
}

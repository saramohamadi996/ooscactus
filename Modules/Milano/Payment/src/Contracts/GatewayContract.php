<?php
namespace Milano\Payment\Contracts;

use Milano\Order\Models\Order;
use Milano\Payment\Models\Payment;

interface GatewayContract
{
    public function request($amount, $description);

    public function verify(Payment $payment);

    public function redirect();

    public function getName();
}

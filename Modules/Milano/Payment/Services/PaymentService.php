<?php
namespace Milano\Payment\Services;
use Illuminate\Support\Str;
use Milano\Payment\Gateways\Gateway;
use Milano\Payment\Models\Payment;
use Milano\Payment\Repositories\PaymentRepo;
use Milano\User\Models\User;

class PaymentService
{
    public static function generate($amount, $paymentable, User $buyer, $order_id, $seller_id = null, $discounts = [])
    {
        if ($amount <= 0 || is_null($paymentable->id) || is_null($buyer->id)) return false;
        $gateway = resolve(Gateway::class);
        $invoiceId = $gateway->request($amount, $paymentable->title);
        if (is_array($invoiceId)) {
            // todo
            dd($invoiceId);
        }
        $site_share=0;
        $seller_p=0;
        $seller_share=0;
        foreach($paymentable->orderItems as $item) {
            $itemTotalPrice = (($item->price * ((100-$item->coupon)/100)) * $item->count);
            $k=$itemTotalPrice *((100-$item->seller_share)/100);
            $site_share+=($itemTotalPrice-$k);
            $seller_share+=$k;
        }
        $ref = Str::random(16);

        return resolve(PaymentRepo::class)->store([
            "order_id" => $order_id,
            "buyer_id" => $buyer->id,
            "paymentable_id" => $paymentable->id,
            "paymentable_type" => get_class($paymentable),
            "seller_id" => $seller_id,
            "seller_p" => $seller_p,
            "seller_share" => $seller_share,
            "site_share" => $site_share,
            "amount" => $amount,
            "invoice_id" => $invoiceId,
            "gateway" => $gateway->getName(),
            "status" => Payment::STATUS_PENDING,
            "ref_num" => $ref,
        ],$discounts);
    }
}

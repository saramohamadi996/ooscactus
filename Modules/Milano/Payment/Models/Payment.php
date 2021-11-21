<?php

namespace Milano\Payment\Models;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Milano\Cart\Models\Cart;
use Milano\Order\Models\Order;
use Milano\Product\Models\Product;
use Milano\User\Models\User;

class Payment extends Model
{
    protected $guarded = [];
    const STATUS_SUCCESS = "success";
    const STATUS_PENDING = "pending";
    const STATUS_CANCELED = "canceled";
    const STATUS_FAIL = "fail";
    public static $statuses = [
        self::STATUS_SUCCESS,
        self::STATUS_PENDING,
        self::STATUS_CANCELED,
        self::STATUS_FAIL,
    ];
    public function paymentable()
    {
        return $this->morphTo();
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function buyer()
    {
        return $this->belongsTo(User::class, "buyer_id");
    }
    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }
    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatJalaliDate();
    }
}

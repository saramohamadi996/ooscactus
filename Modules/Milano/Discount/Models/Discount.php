<?php

namespace Milano\Discount\Models;

use Milano\Product\Models\Product;
use Milano\Payment\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
   const TYPE_ALL = "all";
   const TYPE_SPECIAL = "special";
    public static $types = [
        self::TYPE_ALL,
        self::TYPE_SPECIAL
    ];
    protected $guarded = [];
    protected $casts = [
        "expire_at" => "datetime"
    ];
    public function products()
    {
        return $this->morphedByMany(Product::class, "discountable");
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, "discount_payment");
    }
}

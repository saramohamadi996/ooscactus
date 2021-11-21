<?php
namespace Milano\Coupon\Models;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Milano\Category\Models\Category;
use Milano\Product\Models\Product;
use Milano\User\Models\User;

class Coupon extends Model
{
    protected $guarded = [];
    const STATUS_ENABLE = 'enable';
    const STATUS_DISABLE = 'disable';
    static $statuses = [self::STATUS_ENABLE , self::STATUS_DISABLE];

    public function users()
    {
        return $this->morphedByMany(User::class , 'couponable');
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class , 'couponable');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class , 'couponable');
    }

    public function getJalaliStartAtAttribute()
    {
        $v = new Verta($this->start_at);
        return $v->formatJalaliDate();
    }

    public function getJalaliExpiredAtAttribute()
    {
        $v = new Verta($this->expired_at);
        return $v->formatJalaliDate();
    }

    public function getquantityCountAttribute()
    {
        return (is_null($this->quantity)) ?'نامحدود' : $this->quantity. ' ' . 'عدد';
    }
    public function getlimitAmountAttribute()
    {
        return (is_null($this->limit)) ?'نامشخص' : number_format($this->amount). ' ' . 'تومان';
    }

    public function userUsedCoupons()
    {
        return $this->belongsToMany(User::class , 'coupon_used');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}


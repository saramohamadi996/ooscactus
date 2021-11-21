<?php
namespace Milano\Cart\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milano\Coupon\Models\Coupon;
use Milano\Order\Models\Order;
use Milano\Payment\Models\Payment;
use Milano\Product\Models\Product;
use Milano\User\Models\User;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    const Active = 'Active';

    public function items()
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "cart_products")
            ->withPivot(['count' ,'price' , 'total_price']);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function getPrice()
    {
        return number_format($this->total_price);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function getDiscountPercent()
    {
        return optional($this->coupon)->percent;
    }

    public function getDiscountAmount()
    {
        return ($this->coupon) ? ($this->total_price * $this->coupon->percent) / 100 : 0;

    }
    public function getFinalPrice()
    {
        return number_format($this->total_price - $this->getDiscountAmount());
    }
}

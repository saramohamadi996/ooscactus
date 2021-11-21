<?php
namespace Milano\Product\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Milano\Category\Models\Category;
use Milano\Order\Models\Order;
use Milano\Payment\Models\Payment;
use Milano\User\Models\User;
use Milano\Comment\Models\Comment;
use Milano\Cart\Models\Cart;

class Product extends Model
{
    protected $guarded = [];
    protected $table = 'products';

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses =
    [self::CONFIRMATION_STATUS_ACCEPTED,
    self::CONFIRMATION_STATUS_PENDING,
    self::CONFIRMATION_STATUS_REJECTED];

    const STATUS_AVAILABLE = 'available';
    const STATUS_UNAVAILABLE = 'unavailable';
    static $statuses = [self::STATUS_AVAILABLE, self::STATUS_UNAVAILABLE];

    public function popularProducts()
    {
        return $this->withCount('orders')
            ->orderByDesc('orders_count')
            ->whereHas('orders', function ($q) {
                $q->where('status', 'registered');
            })->take(6)->get();
    }
    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }
    public function seller(){

        return $this->belongsTo(User::class , 'seller_id');
    }
    public function images()
    {
        return $this->hasMany(ImageProduct::class , 'product_id');
    }
    public function path()
    {
        return route('singleProduct', $this->id . '-' . $this->slug);
    }
    public function shortUrl()
    {
        return route('singleProduct', $this->id);
    }
    public function getsellerImageAttribute()
    {
        if($this->seller->image){
            return  ('/storage/' . $this->seller->image);
        }else{return url('/img/profile.jpg');}
    }
//    public function tags()
//    {
//        return $this->morphToMany(Tag::class, 'taggable');
//    }
    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable');
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class ,'cart_products');
    }
    public function cartProducts()
    {
        return $this->belongsTomany(Cart::class , 'cart_products');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class ,'order_items');
    }
    public function payments()
    {
        return $this->morphMany(Payment::class, "paymentable");
    }
    public function getFormattedPrice()
    {
        return number_format($this->price);
    }
    public function getDiscountPercent()
    {
        return 0;
    }
    public function getDiscountAmount()
    {
        return 0;
    }
    public function getFinalPrice()
    {
        return $this->price - $this->getDiscountAmount();
    }
    public function getFormattedFinalPrice()
    {
        return number_format($this->getFinalPrice());
    }
    public function coupons()
    {
        return $this->morphToMany(Coupon::class , 'couponable');
    }
    public function hasStock(int $count)
    {
        return $this->stock >= $count;
    }
    public function decrementStock(int $count)
    {
        return $this->decrement('stock', $count);
    }
    public function scopeFilter($query)
    {
        $category = request('category');
        if (isset($category)) {
            $query->whereHas('category' , function($query) use($category){
                $query->where('title' , $category)->orWhere('slug' , $category);
            });
        }
        if(request('create') == 'old'){
            $query->oldest();}else{$query->latest();}

        if(request('status') ==  self::STATUS_AVAILABLE){
            return $query->where('status' , self::STATUS_AVAILABLE);
        }elseif(request('status') ==  self::STATUS_UNAVAILABLE){
            return $query->where('status' , self::STATUS_UNAVAILABLE);
        }

        $seller = request('seller');
        if (isset($seller)) {
            $query->whereHas('seller' , function($query) use($seller){
                $query->where('id' , $seller);
            });
        }
    }
}

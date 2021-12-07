<?php

namespace Milano\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Milano\Category\Models\Category;
use Milano\Order\Models\Order;
use Milano\Payment\Models\Payment;
use Milano\User\Models\User;
use Milano\Comment\Models\Comment;
use Milano\Cart\Models\Cart;

/**
 * Class Product
 * @property int $id
 * @property int $seller_id
 * @property int $category_id
 * @property int $product_id
 * @property string $image
 * @property string $title
 * @property string $meta_description
 * @property string $slug
 * @property int $priority
 * @property int $price
 * @property int $seller_share
 * @property int $stock
 * @property string $code_product
 * @property boolean $status
 * @property boolean $is_enabled
 * @property string $body
 * @package Milano\Product\Models
 */
class Product extends Model
{
    /**
     * define Product's table.
     * @var string
     */
    protected $table = 'products';

    /**
     * product if the model should be timestamped.
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be fallible.
     * @var string[]
     */
    protected $fillable = [
        'seller_id', 'category_id', 'image', 'title', 'meta_description', 'slug', 'priority',
        'price', 'seller_share', 'stock', 'status', 'code_product', 'body', 'is_enabled',
    ];

    /**
     * The attributes that should be cast.
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'stock' => 'integer',
        'seller_id' => 'integer',
        'category_id' => 'integer',
        'meta_description' => 'string',
        'seller_share' => 'string',
        'priority' => 'string',
        'image' => 'string',
        'title' => 'string',
        'slug' => 'string',
        'price' => 'string',
        'body' => 'string',
        'code_product' => 'string',
        'is_enabled' => 'boolean',
        'status' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];


    /**
     * @return HasMany
     */
    public function images()
    {
        return $this->hasMany(ImageProduct::class, 'product_id');
    }

    public function popularProducts()
    {
        return $this->withCount('orders')
            ->orderByDesc('orders_count')
            ->whereHas('orders', function ($q) {
                $q->where('status', 'registered');
            })->take(6)->get();
    }

    /**
     * Get the category for the product.
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the seller for the product.
     * @return BelongsTo
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function path()
    {
        return route('singleProduct', $this->id . '-' . $this->slug);
    }

    public function shortUrl()
    {
        return route('singleProduct', $this->id);
    }

    /**
     * Get all of the product's comments.
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where("status", Comment::STATUS_APPROVED);
    }

    /**
     * The carts that belong to the product.
     * @return BelongsToMany
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_products');
    }

    /**
     * The cartProducts that belong to the product.
     * @return BelongsToMany
     */
    public function cartProducts()
    {
        return $this->belongsTomany(Cart::class, 'cart_products');
    }

    /**
     * The orders that belong to the product.
     * @return BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }

    /**
     * Get all of the product's payments.
     * @return MorphMany
     */
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
        $product = request('product');
        if (isset($product)) {
            $query->whereHas('product', function ($query) use ($product) {
                $query->where('title', $product)->orWhere('slug', $product);
            });
        }
        if (request('create') == 'old') {
            $query->oldest();
        } else {
            $query->latest();
        }

        if (request('status') == 1) {
            return $query->where('status', 1);
        } elseif (request('status') == 0) {
            return $query->where('status', 0);
        }

        $seller = request('seller');
        if (isset($seller)) {
            $query->whereHas('seller', function ($query) use ($seller) {
                $query->where('id', $seller);
            });
        }
    }
}

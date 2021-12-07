<?php

namespace Milano\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Milano\Cart\Models\Cart;
use Milano\Comment\Models\Comment;
use Milano\Coupon\Models\Coupon;
use Milano\Order\Models\Order;
use Milano\Payment\Models\Payment;
use Milano\Payment\Models\Settlement;
use Milano\Product\Models\ImageProduct;
use Milano\Product\Models\Product;
use Milano\RolePermissions\Models\Role;
use Milano\Ticket\Models\Reply;
use Milano\Ticket\Models\Ticket;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    use HasFactory;

    protected $table = 'users';

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BAN = "ban";
    public static $statuses = [
        self::STATUS_ACTIVE,
        self:: STATUS_INACTIVE,
        self::STATUS_BAN,
    ];
    public static $defaultUsers = [
        [
            'email' => 'admin@site.com',
            'password' => 'admin',
            'name' => 'Admin',
            'role' => Role::ROLE_SUPER_ADMIN
        ],
        [
            'email' => 'seller@site.com',
            'password' => 'seller',
            'name' => 'Seller',
            'role' => Role::ROLE_SELLER
        ],
        [
            'email' => 'customer@site.com',
            'password' => 'customer',
            'name' => 'Customer',
            'role' => Role::ROLE_CUSTOMER
        ]
    ];


    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'username'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the verify code associated with the user.
     */
    public function verifyCode()
    {
        return $this->hasOne(VerifyCode::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function images()
    {
        return $this->belongsTo(ImageProduct::class, 'image_id');
    }

    public function profilePath()
    {
        return null;
        return $this->username ? route('viewProfile', $this->username) : route('viewProfile', 'username');
    }

    public function getUserImageAttribute()
    {
        if ($this->image) {
            return '/storage/' . $this->image;
        } else {
            return url('/img/profile.jpg');
        }
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, "buyer_id");
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(Reply::class);
    }

    public function routeNotificationForSms()
    {
        return $this->mobile;
    }
}

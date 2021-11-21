<?php
namespace Milano\User\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Milano\Cart\Models\Cart;
use Milano\Coupon\Models\Coupon;
use Milano\Order\Models\Order;
use Milano\Payment\Models\Payment;
use Milano\Payment\Models\Settlement;
use Milano\Product\Models\ImageProduct;
use Milano\Product\Models\Product;
use Milano\RolePermissions\Models\Role;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasFactory;

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
            'username' => 'Admin',
            'role' => Role::ROLE_SUPER_ADMIN
        ],
        [
            'email' => 'seller@site.com',
            'password' => 'seller',
            'name' => 'Seller',
            'username' => 'Seller',
            'role' => Role::ROLE_SELLER
        ],
        [
            'email' => 'customer@site.com',
            'password' => 'customer',
            'name' => 'Customer',
            'username' => 'Customer',
            'role' => Role::ROLE_CUSTOMER
        ]
    ];

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'username'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
    public function images()
    {
        return $this->belongsTo(ImageProduct::class , 'image_id');
    }
    public function profilePath()
    {
        return $this->username ? route('viewProfile', $this->username)
            : route('viewProfile', 'username');
    }
    public function getuserImageAttribute()
    {
        if($this->image){
        return '/storage/'. $this->image;
        }else{
            return url('/img/profile.jpg');
        }
    }
    public function carts(){
        return $this->hasMany(Cart::class);
    }
    public function order(){
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
    public function coupons()
    {
        return $this->morphToMany(Coupon::class , 'couponable');
    }
}

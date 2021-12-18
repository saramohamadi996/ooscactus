<?php

namespace Milano\User\Models;

use Illuminate\Support\Facades\DB;
use Milano\Comment\Models\Comment;
use Milano\Product\Models\Product;
use Milano\Payment\Models\Payment;
use Milano\Payment\Models\Settlement;
use Milano\RolePermissions\Models\Role;
use Milano\Ticket\Models\Reply;
use Milano\Ticket\Models\Ticket;
use Milano\User\Notifications\ResetPasswordRequestNotification;
use Milano\User\Notifications\VerifyMailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasFactory;

    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BAN = "ban";
    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN
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
            'name' => 'Student',
            'role' => Role::ROLE_CUSTOMER
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyMailNotification());
    }

    public function sendResetPasswordRequestNotification()
    {
        $this->notify(new ResetPasswordRequestNotification());
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function purchases()
    {
        return $this->belongsToMany(Product::class, 'product_user', 'user_id', 'product_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, "buyer_id");
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(Reply::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function profilePath()
    {
        return null;
        return $this->username ? route('viewProfile', $this->username) : route('viewProfile', 'username');
    }

    public function getThumbAttribute()
    {
        if ($this->image)
            return '/storage/' . $this->image->files[300];
        return '/panel/img/profile.jpg';
    }


    public function customersCount()
    {
        return DB::table("products")
            ->select("product_id")->where("seller_id", $this->id)
            ->join("product_user", "products.id", "=", "product_user.product_id")->count();
    }

    public function routeNotificationForSms()
    {
        return $this->mobile;
    }
}

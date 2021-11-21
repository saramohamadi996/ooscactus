<?php
namespace Milano\Order\Models;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milano\Cart\Models\Cart;
use Milano\Payment\Models\Payment;
use Milano\Product\Models\Product;
use Milano\User\Models\User;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    const STATUS_REGISTERED = 'registered';
    const STATUS_PREPARING = 'preparing';
    const STATUS_SENT = 'sent';
    static $statuses = [self::STATUS_REGISTERED,
        self::STATUS_PREPARING, self::STATUS_SENT];


    public function products()
    {
        return $this->belongsToMany(Product::class, "order_items");
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPrice()
    {
        return number_format($this->total_price);
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function buyer()
    {
        return $this->belongsTo(User::class);
    }
    public function getUserAddressAttribute()
    {
        return $this->state . " " . $this->city." " . $this->street . " " .$this->alley . " " . $this->no . " " . $this->notes;
    }
    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatJalaliDate();
    }


}

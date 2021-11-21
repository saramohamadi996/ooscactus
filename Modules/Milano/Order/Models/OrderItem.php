<?php
namespace Milano\Order\Models;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Milano\Cart\Models\Cart;
use Milano\Payment\Models\Payment;
use Milano\Product\Models\Product;
use Milano\User\Models\User;

class OrderItem extends Model
{
    protected $fillable = ['product_id', 'count', 'price','title', 'code_product', 'order_id'];
}

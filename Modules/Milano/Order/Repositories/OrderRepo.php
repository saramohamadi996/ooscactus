<?php
namespace Milano\Order\Repositories;
use Milano\Cart\Models\Cart;
use Milano\Order\Models\Order;

class OrderRepo
{
    private $findByid;
    private $query;
    public function __construct()
    {
        $this->query = Order::query();
    }
    public function all(){
        return Order::all();
    }
//    public function paginate()
//    {
//        return $this->query->latest()->paginate();
//    }
    public function findByid($id)
    {
        return Order::findOrFail($id);
    }

    public function details($id)
    {
        return Order::query()->with('user')->findOrFail($id);
    }

    public function OrderBuy($values)
    {
            $cart = Cart::findOrFail($values->input('cart_id', 'total_price'));
        $order = auth()->user()->order()->create([
            'name' => $values->name,
            'mobile' => $values->mobile,
            'state' => $values->state,
            'city' => $values->city,
            'total_price' => $cart->total_price,
        ]);
        $order->orderItems()->attach($cart->products);
        $order->products()->sync($cart->products);
    }

    public function searchAfterDate($date)
    {
        if (!is_null($date)) {
            $this->query->whereDate("created_at", ">=", $date);
        }return $this;
    }

    public function searchBeforeDate($date)
    {
        if (!is_null($date)) {
            $this->query->whereDate("created_at", "<=", $date);
        }return $this;
    }

    public function paginate()
    {
        return $this->query->latest()->paginate();
    }

    public function preparing($orderId)
    {
        return Order::where('id' , $orderId)->update(['status' => Order::STATUS_PREPARING]);
    }
    public function sent($orderId)
    {
        return Order::where('id' , $orderId)->update(['status' => Order::STATUS_SENT]);
    }
}

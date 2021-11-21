<?php

namespace Milano\Order\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milano\Cart\Repositories\CartRepo;
use Milano\Order\Http\Requests\OrderRequest;
use Milano\Order\Models\Order;
use Milano\Cart\Models\Cart;
use Milano\Order\Repositories\OrderRepo;
use Milano\Payment\Gateways\Gateway;
use Milano\Payment\Repositories\PaymentRepo;
use Milano\Payment\Services\PaymentService;

use Milano\Payment\Models\Payment;

class OrderController extends Controller
{
    public $repo;
    public $cartRepo;
    public $paymentRepo;

    public function __construct(OrderRepo $orderRepo, CartRepo $cartRepo, PaymentRepo $paymentRepo)
    {
        $this->repo = $orderRepo;
        $this->cartRepo = $cartRepo;
        $this->paymentRepo = $paymentRepo;
    }

    public function checkout(Request $request)
    {
        $order = $this->repo;
        $cart = auth()->user()->carts()->where('status', 'Active')->first();
        return view('Front::checkout', compact('order', 'cart'));
    }

    public function OrderBuy(Request $request, Payment $payment, Order $order, Cart $cart)
    {
        $cart = Cart::findOrFail($request->input('cart_id'));
        $site_share=0;
        $seller_p=0;
        $seller_share=0;
        foreach($order->orderItems as $item) {
            $itemTotalPrice = ($item->price * $item->count);
            $k=$itemTotalPrice *($item->seller_share/100);
            $site_share+=($itemTotalPrice-$k);
            $seller_share+=$k;
        }
        $order = auth()->user()->order()->create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'state' => $request->state,
            'city' => $request->city,
            'street' => $request->street,
            'street' => $request->street,
            'alley' => $request->alley,
            'alley' => $request->alley,
            'no' => $request->no,
            'notes' => $request->notes,
            'total_price' => $cart->total_price,
        ]);
        $items = $cart->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'code_product' => $item->code_product,
                'title' => $item->title,
                'count' => $item->count,
                'price' => $item->price,
            ];
        })->toArray();
        $order->orderItems()->createMany($items);
        $payment = PaymentService::generate($order->total_price ,$order ,auth()->user(), $order->id);
        resolve(Gateway::class)->redirect($payment->invoice_id);
    }

    public function index(Request $request)
    {
        $orders = $this->repo
            ->searchAfterDate(dateFromJalali($request->start_date))
            ->searchBeforeDate(dateFromJalali($request->end_date))
            ->paginate();
        return view('orders::index', compact('orders'));
    }

    public function details($id)
    {
        $order = $this->repo->findByid($id);
        return view('orders::details', compact('order'));
    }

    public function preparing($orderId)
    {
        $order = $this->repo->preparing($orderId);
        $this->authorize('change_status', $order);
    }

    public function sent($orderId)
    {
        $order = $this->repo->sent($orderId);
        $this->authorize('change_status', $order);
    }
}


<?php
namespace Milano\Cart\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Milano\Cart\Exceptions\CountExceededException;
use Milano\Cart\Models\Cart;
use Milano\Cart\Models\CartProduct;
use Milano\Cart\Repositories\CartRepo;
use Milano\Payment\Gateways\Gateway;
use Milano\Payment\Models\Payment;
use Milano\Payment\Models\Transaction;
use Milano\Payment\Repositories\PaymentRepo;
use Milano\Payment\Services\PaymentService;
use Milano\Product\Models\Product;
use Milano\Common\Responses\AjaxResponses;

class CartController extends Controller
{
    public $repo;
    public $paymentRepo;
    public function __construct(CartRepo $cartRepo, PaymentRepo  $paymentRepo)
    {
        $this->repo = $cartRepo;
        $this->paymentRepo = $paymentRepo;
    }

    protected function ActiveCart(){
        $cart = Auth::user()->carts()->where('status' , Cart::Active)->first();
        if (!$cart){
            $cart = Auth::user()->carts()->create([
                'status' => Cart::Active,
                'total_price' => 0,
            ]);}return $cart;
    }

    public function myCart(){
        $cart = $this->ActiveCart();
        $products = $cart->products;
        return view('Front::cart', compact('products', 'cart'));
    }

    public function addToCart(Request $request){
        $cart = $this->ActiveCart();
        $requestCount = $request->exists('count') ? $request->input('count') : 1;
        $product = Product::find($request->input('product_id'));
        $cartProduct = $cart->products()->where('product_id' , $product->id)->first();
        $count = ($cartProduct?$cartProduct->pivot->count:0)+$requestCount;
        if ($product->stock < $count ){return back()->withErrors(['addtocart' => 'موجودی کالا کافی نمیباشد']);}
        if ($cartProduct){
            $cartProduct->pivot->count =  $count;
            $cartProduct->pivot->price = $product->price;
            $cartProduct->pivot->total_price = ($count*$product->price * ((100-$product->coupon)/100));
            $cartProduct->pivot->save();
        }else{
            $cart->products()->attach($product->id ,[
                'product_id' => $product->id,
                'code_product' => $product->code_product,
                'title' => $product->title,
                'count' => $count,
                'price' => $product->price,
                'total_price' => ($count*($product->price * (100-$product->coupon)/100))
            ]);
        }
        $this->CalculateTotalPrice();
        return redirect('/cart');
    }

    public function update(Request $request)
    {
        $this->validate($request,["count"=>"numeric|required|min:1"]);
        $cart = Cart::where('user_id',Auth::id())->first();
        $item=$cart->products->where('id',$request->product)->first();
        if($item) {
            if($request->count<=$item->stock) {
                $item->pivot->count = $request->count;
                $item->pivot->total_price = $item->price * ((100-$item->coupon)/100) * $request->count;
                $item->pivot->save();
                $this->CalculateTotalPrice();
            }}return back();
    }

    protected function CalculateTotalPrice(){
        $cart = $this->ActiveCart();
        $cart->total_price = 0;
        foreach ($cart->products as $product){
            $product->pivot->price = $product->price;
            $product->pivot->total_price = $product->pivot->count *($product->price*(100-$product->coupon)/100);
            $cart->total_price += $product->pivot->count *($product->price*(100-$product->coupon)/100);
        }
        $cart->save();
    }

    public function CartDelete()
    {
        $cart = $this->ActiveCart();
        $product = $cart->products()->where('product_id', request('product'))->first();
        if ($cart->products->isNotEmpty()) {
            $cart->total_price  = $cart->total_price - $product->pivot->total_price;
            $cart->products()->detach($product);
//            auth()->user()->carts()->delete();
//            return redirect('/');
        }
        $this->CalculateTotalPrice();
        return back();
    }
}

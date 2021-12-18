<?php

namespace Milano\Cart\Repositories;

use Illuminate\Support\Facades\Auth;
use Milano\Cart\Models\Cart;
use Milano\Product\Models\Product;

class CartRepo
{
    private $findByid;

    protected function ActiveCart()
    {
        $cart = Auth::user()->carts()->where('status', Cart::Active)->first();
        if (!$cart) {
            $cart = Auth::user()->carts()->create([
                'status' => Cart::Active,
                'total_price' => 0,
            ]);
        }
    }

    public function myCart()
    {
        $products = Product::all();
        $cart = $this->ActiveCart();
        $products = $cart->products;
        return view('Front::cart', compact('products', 'cart'));
    }

    public function addToCart($values)
    {
        $valuesCount = $values->exists('count') ? $values->input('count') : 1;
        $product = Product::find($values->input('product_id'));
        $cart = Cart::all();
        $cartProduct = $cart->products()->where('product_id', $product->id)->first();
        $count = ($cartProduct ? $cartProduct->pivot->count : 0) + $valuesCount;
        if ($product->stock < $count) {
            return back()->withErrors(['addtocart' => 'موجودی کالا کافی نمیباشد']);
        }
        if ($cartProduct) {
            $cartProduct->pivot->count = $count;
            $cartProduct->pivot->price = $product->price;
            $cartProduct->pivot->total_price = $count * $product->price;
            $cartProduct->pivot->save();
        } else {
            $cart->products()->attach($product->id, [
                'product_id' => $product->id,
                'count' => $count,
                'price' => $product->price,
                'total_price' => $count * $product->price
            ]);
        }
    }
}

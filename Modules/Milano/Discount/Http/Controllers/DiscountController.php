<?php

namespace Milano\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use Milano\Common\Responses\AjaxResponses;
use Milano\Discount\Http\Requests\DiscountRequest;
use Milano\Discount\Models\Discount;
use Milano\Discount\Repositories\Interfaces\DiscountRepositoryInterface;
use Milano\Discount\Services\DiscountService;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;

class DiscountController extends Controller
{
    protected ProductRepositoryInterface $product_repository;
protected DiscountRepositoryInterface $discount_repository;
    public function __construct(ProductRepositoryInterface $product_repository,
                                DiscountRepositoryInterface $discount_repository)
    {
        $this->product_repository = $product_repository;
        $this->discount_repository = $discount_repository;
    }
    public function index()
    {
        $this->authorize("manage", Discount::class);
        $discounts = $this->discount_repository->paginateAll();
        $products = $this->product_repository->getAll();
        return view("Discounts::index", compact("products", "discounts"));
    }

    public function store(DiscountRequest $request)
    {
        $this->authorize("manage", Discount::class);
        $this->discount_repository->store($request->all());
//        newFeedback();
        return back();
    }

    public function edit(Discount $discount)
    {
        $this->authorize("manage", Discount::class);
        $products = $this->product_repository->getAll();
        return view("Discounts::edit", compact("discount", "products"));
    }

    public function update(DiscountRequest $request)
    {
        $this->authorize("manage", Discount::class);
        $this->discount_repository->update($discount->id, $request->all());
        newFeedback();
        return redirect()->route("discounts.index");

    }

    public function destroy(Discount $discount)
    {
        $this->authorize("manage", Discount::class);
        $discount->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function check($code)
    {
        $discount = $this->discount_repository->getValidDiscountByCode($code, $product->id);
        if ($discount){
            $discountAmount = DiscountService::calculateDiscountAmount($product->getFinalPrice(), $discount->percent);
            $discountPercent = $discount->percent;
            $response = [
                "status" => "valid",
                "payableAmount" => $product->getFinalPrice() - $discountAmount,
                "discountAmount" => $discountAmount,
                "discountPercent" => $discountPercent
            ];
            return response()->json($response);
        }
        return response()->json(["status" => "invalid"])->setStatusCode(422);
    }
}

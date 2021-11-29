<?php

namespace Milano\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use Milano\Common\Responses\AjaxResponses;
use Milano\Course\Models\Course;
use Milano\Course\Repositories\CourseRepo;
use Milano\Discount\Http\Requests\DiscountRequest;
use Milano\Discount\Models\Discount;
use Milano\Discount\Repositories\DiscountRepo;
use Milano\Discount\Services\DiscountService;

class DiscountController extends Controller
{
    public function index(CourseRepo $courseRepo, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $discounts = $repo->paginateAll();
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view("Discounts::index", compact("courses", "discounts"));
    }

    public function store(DiscountRequest $request, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $repo->store($request->all());
        newFeedback();
        return back();
    }

    public function edit(Discount $discount, CourseRepo $courseRepo)
    {
        $this->authorize("manage", Discount::class);
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view("Discounts::edit", compact("discount", "courses"));
    }

    public function update(Discount $discount, DiscountRequest $request, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $repo->update($discount->id, $request->all());
        newFeedback();
        return redirect()->route("discounts.index");

    }

    public function destroy(Discount $discount)
    {
        $this->authorize("manage", Discount::class);
        $discount->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function check($code, Course $course, DiscountRepo $repo)
    {

        $discount = $repo->getValidDiscountByCode($code, $course->id);
        if ($discount){
            $discountAmount = DiscountService::calculateDiscountAmount($course->getFinalPrice(), $discount->percent);
            $discountPercent = $discount->percent;
            $response = [
                "status" => "valid",
                "payableAmount" => $course->getFinalPrice() - $discountAmount,
                "discountAmount" => $discountAmount,
                "discountPercent" => $discountPercent
            ];
            return response()->json($response);
        }

        return \response()->json([
            "status" => "invalid"
        ])->setStatusCode(422);
    }
}

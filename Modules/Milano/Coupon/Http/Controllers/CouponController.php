<?php
namespace Milano\Coupon\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milano\Category\Repositories\CategoryRepo;
use Milano\Coupon\Http\Requests\CouponRequest;
use Milano\Category\Models\Category;
use Milano\Common\Responses\AjaxResponses;
use Milano\Coupon\Models\Coupon;
use Milano\Coupon\Repositories\CouponRepo;
use Milano\Product\Models\Product;
use Milano\Product\Repositories\ProductRepo;
use Milano\User\Models\User;
use Milano\User\Repositories\UserRepo;

class CouponController extends Controller
{
    public $repo;
    public $userRepo;
    public $productRepo;
    public $categoryRepo;
    public function __construct(CouponRepo $couponRepo,
     ProductRepo $productRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->repo = $couponRepo;
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $coupons =  $this->repo->paginate();
        $this->authorize('index', $coupons);
        return view('Coupons::index', compact('coupons'));
    }

    public function create()
    {
        $coupons = $this->repo;
        $users = $this->userRepo->getUsers();
        $products = $this->productRepo->getProducts();
        $categories = $this->categoryRepo->all();
        $this->authorize('create', $coupons);
        return view('Coupons::create', compact('categories','users', 'products'));
    }

    public function store(CouponRequest $request)
    {
        $coupon = $this->repo->store($request);
        $coupon->categories()->attach($request->category_id);
        $coupon->users()->attach($request->user_id);
        $coupon->products()->attach($request->product_id);
        return redirect(route('coupons.index'));
    }

    public function edit($id)
    {
        $coupon =$this->repo->findByid($id);
        $this->authorize('edit', $coupon);
        $users = $this->userRepo->getUsers();
        $products = $this->productRepo->getProducts();
        $categories = $this->categoryRepo->all();
        return view('Coupons::edit', compact('coupon',
            'categories', 'users', 'products'));
    }

    public function update($id, Request $request)
    {
        $coupon = $this->repo->update($request,$id);
        $this->authorize('edit', $coupon);
        //TODO request class and convert date
        return redirect(route('coupons.index'));
    }

    public function destroy($id)
    {
        $coupon = $this->repo->findByid($id);
        $this->authorize('delete', $coupon);
        $coupon->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $coupon = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $coupon);
    }

    public function reject($id)
    {
        $coupon = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $coupon);
    }
}

<?php
namespace Milano\Product\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Milano\Category\Repositories\CategoryRepo;
use Milano\Common\Responses\AjaxResponses;
use Milano\Product\Http\Requests\ProductRequest;
use Milano\Product\Models\Product;
use Milano\Product\Repositories\ProductRepo;
use Milano\User\Repositories\UserRepo;


class ProductController extends Controller
{
    public $repo;
    public $userRepo;
    public $categoryRepo;
    public function __construct(ProductRepo $productRepo, UserRepo $userRepo,
           CategoryRepo $categoryRepo)
    {
        $this->repo = $productRepo;
        $this->userRepo = $userRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $products = $this->repo
            ->searchTitle($request->title)
            ->searchPrice($request->price)
            ->searchPriority($request->priority)
            ->searchCodeProduct($request->code_product)->paginate();
        $this->authorize('index', $products);
        return view('Products::index', compact('products'));
    }

    public function create()
    {
        $product =$this->repo;
        $this->authorize('create', $product);
        $categories = $this->categoryRepo->all();
        $sellers = $this->userRepo->getSellers();
        return view('Products::create', compact('categories', 'sellers'));
    }

    public function store(ProductRequest $request)
    {
        $images = [];
        $this->repo->store($request, $images);
        return redirect(route('products.index'));
    }

    public function edit($id)
    {
        $product = $this->repo->findByid($id);
        $sellers = $this->userRepo->getSellers();
        $categories = $this->categoryRepo->all();
        return view('Products::edit', compact('product', 'sellers', 'categories', 'product'));
    }

    public function update($id, Request $request)
    {
        $product = $this->repo->update($request ,$id);
        $this->authorize('edit', $product);
        return redirect(route('products.index'));
    }

    public function destroy($id)
    {
        $product = $this->repo->findByid($id);
        $this->authorize('delete', $product);
        if ($product->banner) {
            $product->banner->delete();
        }$product->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $product = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $product);
    }

    public function reject($id)
    {
        $product = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $product);
    }

    public function coupon(Request $request)
    {
        Product::where("id", $request->id)->update([
            "coupon" => $request->coupon
        ]);
        return redirect()->back();

    }
}


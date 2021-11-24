<?php

namespace Milano\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Milano\Media\Services\MediaFileService;
use Milano\Product\Http\Requests\ProductAllRequest;
use Milano\Product\Http\Requests\ProductStoreRequest;
use Milano\Product\Http\Requests\ProductUpdateRequest;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;
use Milano\User\Repositories\Interfaces\UserRepositoryInterface;

class ProductController extends Controller
{
    /**
     * The category repository instance.
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $product_repository;

    /**
     * The category repository instance.
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $category_repository;

    /**
     * The category repository instance.
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $user_repository;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $product_repository
     * @param CategoryRepositoryInterface $category_repository
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(ProductRepositoryInterface $product_repository,
                                CategoryRepositoryInterface $category_repository,
                                UserRepositoryInterface $user_repository)
    {
        $this->product_repository = $product_repository;
        $this->category_repository = $category_repository;
        $this->user_repository = $user_repository;
    }

    /**
     * Display a listing of the resource.
     * @param ProductAllRequest $request
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(ProductAllRequest $request)
    {
        $input = $request->only(['title', 'priority', 'price', 'code_product', 'seller_id', 'category_id',]);
        $products = $this->product_repository->paginate($input);
        $this->authorize('index', $products);
        return view('Products::index', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $product = $this->product_repository->findByid($id);
        $sellers = $this->user_repository->getSellers();
        $categories = $this->category_repository->getAll($id);
        $this->authorize('edit', $product);
        return view('Products::edit', compact(
            'product', 'sellers', 'categories', 'product'));
    }

    /**
     * create the form for creating a new resource.
     * @param int $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $id = [];
        $product = $this->product_repository->getAll();
        $this->authorize('create', $product);
        $sellers = $this->user_repository->getSellers();
        $categories = $this->category_repository->getAll($id);
        return view('Products::create', compact('categories', 'sellers'));
    }

    /**
     * Store a newly created resource in storage.
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $input = $request->only('seller_id', 'category_id', 'title', 'meta_description', 'slug', 'priority',
            'price', 'seller_share', 'body', 'image', 'stock', 'confirmation_status');
        dd($request->image);

        $request->request->add(['image' => MediaFileService::publicUpload($request->file('image'))->id]);

//        if ($request->has('image')) {
//            try {
//                $input['image'] = $request->file('image')->store('product', 'public');
//            } catch (QueryException $queryException) {
//                Log::error($queryException->getMessage());
//            }
//        }
        $result = $this->product_repository->store($input);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات ذخیره سازی با شکست مواجه شد.');
        }
        return redirect()->route('products.index')->with('success', 'عملیات ذخیره سازی با موفقیت انجام شد.');
    }

//    public function store(CourseRequest $request, CourseRepo $courseRepo)
//    {
//        $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
//        $courseRepo->store($request);
//        return redirect()->route('courses.index');
//    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param ProductUpdateRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(int $product, ProductUpdateRequest $request)
    {
//        $product =  $this->product_repository->findById($id);
        $input = $request->only('seller_id', 'category_id', 'title', 'meta_description', 'slug', 'priority',
            'price', 'seller_share', 'body', 'image', 'stock', 'code_product', 'confirmation_status');
        $this->authorize('edit', $product);

        $result = $this->product_repository->update($input);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات بروزرسانی با شکست مواجه شد.');
        }
        return redirect()->route('products.index')->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    public function destroy($id)
    {
        $product = $this->repo->findByid($id);
        $this->authorize('delete', $product);
        if ($product->banner) {
            $product->banner->delete();
        }
        $product->delete();
        return AjaxResponses::SuccessResponse();
    }
}

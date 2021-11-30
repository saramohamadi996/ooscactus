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
use Illuminate\Support\Facades\Storage;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Milano\Common\Responses\AjaxResponses;
use Milano\Product\Http\Requests\ProductAllRequest;
use Milano\Product\Http\Requests\ProductStoreRequest;
use Milano\Product\Http\Requests\ProductUpdateRequest;
use Milano\Product\Models\Product;
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
     * @param int $category_id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(ProductAllRequest $request)
    {
        $category_id=[];
        $input = $request->only(['title', 'priority', 'price', 'code_product', 'seller_id', 'category_id',]);
        $products = $this->product_repository->paginate($input);
        $sellers = $this->user_repository->getSellers();
        $categories = $this->category_repository->getAll($category_id);

        $this->authorize('index', $products);
        return view('Products::index', compact('products', 'categories','sellers' ));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $product = $this->product_repository->getById($id);
        $sellers = $this->user_repository->getSellers();
        $categories = $this->category_repository->getAll($id);
        $this->authorize('edit', $product);
        return view('Products::edit', compact(
            'product', 'sellers', 'categories'));
    }

    /**
     * create the form for creating a new resource.
     * @param int $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $category_id = [];
        $product = $this->product_repository->getAll();
        $this->authorize('create', $product);
        $sellers = $this->user_repository->getSellers();
        $categories = $this->category_repository->getAll($category_id);
        return view('Products::create', compact('categories', 'sellers'));
    }

    public function store(ProductStoreRequest $request)
    {
        $images = [];
        $input = $request->only('seller_id', 'category_id', 'title', 'meta_description', 'slug', 'priority',
            'price', 'seller_share', 'body', 'image', 'stock', 'code_product', 'is_enabled');

        if ($request->hasFile('images')) {
            try {
                foreach ($request->images as $image) {
                    $images[] = $image->store("photos/product/", 'public');
                }
            } catch (QueryException | \Exception $ex) {
                Log::error($ex->getMessage());
            }
        }
        $result = $this->product_repository->store($input, $images);
        if (!$result) {
            return redirect()->back()->with('error', 'ایجاد محصول با مشکل مواجه شد');
        }
        return redirect()->route('products.index')->with('success', 'محصول جدید با موفقیت ایجاد شد');
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param ProductUpdateRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update($id, Request $request)
    {
        $product = $this->product_repository->getById($id);
        $input = $request->only('seller_id', 'category_id', 'title', 'meta_description', 'slug', 'priority',
            'price', 'seller_share', 'body', 'image', 'stock', 'code_product', 'is_enabled');
        if ($request->hasFile('images')) {
            try {
                foreach ($request->images as $image) {
                    $product->images()->create([
                        'src' => $image->store("photos/Product/", 'public'),
                        'main_image' => 0
                    ]);
                }
            } catch (QueryException | \Exception $ex) {
                Log::error($ex->getMessage());
            }
        }
        $result = $this->product_repository->update($input, $id);
        if (!$result) {
            return redirect()->back()->with('error', 'بروزرسانی محصول با مشکل مواجه شد');
        }
        return redirect()->route('products.index')->with('success', 'محصول جدید با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id)
    {
        $product = $this->product_repository->getById($id);
        $this->authorize('delete', $product);
        try {
            Storage::disk('public')->delete($product->image);
        } catch (QueryException | \Exception $ex) {
            Log::error($ex->getMessage());
        }
        $result = $this->product_repository->delete($product);
        if (!$result) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    /**
     * enable banner
     * @param int $id
     * @return RedirectResponse
     */
    public function toggle(int $id): RedirectResponse
    {
        $product = $this->product_repository->getById($id);
        $input = ['is_enabled' => !$product->is_enabled];
        $result = $this->product_repository->update($input, $id);
        if (!$result) {
            return redirect()->back()->with('error', 'فعالسازی با مشکل مواجه شد');
        }
        return redirect()->back()->with('success', 'فعال شد');
    }


    /**
     * enable banner
     * @param int $id
     * @return RedirectResponse
     */
    public function status(int $id): RedirectResponse
    {
        $product = $this->product_repository->getById($id);
        $input = ['status' => !$product->status];
        $result = $this->product_repository->update($input, $id);
        if (!$result) {
            return redirect()->back()->with('error', 'فعالسازی با مشکل مواجه شد');
        }
        return redirect()->back()->with('success', 'فعال شد');
    }
}

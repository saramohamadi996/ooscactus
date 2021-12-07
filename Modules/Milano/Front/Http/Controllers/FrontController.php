<?php

namespace Milano\Front\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Milano\Article\Models\Article;
use Milano\Article\Repositories\ArticleRepository;
use Milano\Category\Repositories\CategoryRepository;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Milano\Product\Models\Product;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;
use Milano\Product\Repositories\ProductRepository;
use Milano\RolePermissions\Models\Permission;
use Milano\Setting\Models\Setting;
use Milano\User\Models\User;
use Milano\User\Repositories\Interfaces\UserRepositoryInterface;
use Milano\User\Repositories\UserRepo;
use Milano\User\Rules\ValidMobile;
use Milano\Ads\Models\Ads;

class FrontController
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

    public function index()
    {
        $ads = Ads::accepted()->where('page', 'home')->get();
        return view('Front::index', compact('ads'));
    }

    public function search(Request $request)
    {
        $searchProducts = $searchArticles = collect([]);

        if ($request->search) {
            $searchProducts = Product::when($request->search, function ($query, $search) {
                return $query->whereHas('category', function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%");
                })->orWhere('title', 'LIKE', "%{$search}%");
            })->latest()->paginate(8);

            $searchArticles = Article::when($request->search, function ($query, $search) {
                return $query->whereHas('categories', function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%");
                })->orWhere('title', 'LIKE', "%{$search}%");
            })->latest()->paginate(8);
        }
        return view('Front::search', compact('searchProducts', 'searchArticles'));
    }

    public function allProducts(UserRepo $userRepo)
    {
        $category_id = [];
        $categories = $this->category_repository->getAll($category_id);
        $sellers = $userRepo->getSellers();
        $products = Product::filter()->latest()->paginate(12);
        return view('Front::products.product-list', compact('products', 'categories', 'sellers'));
    }

    public function allArticles()
    {
        $articles = Article::paginate(12);
        return view('Front::articles.article-list', compact('articles'));
    }

    public function singleProduct($slug, ProductRepository $productRepository)
    {
        $ads = Ads::accepted()->where('page', 'single-product')->get();
        $productId = $this->extractId($slug, 'c');
        $product = $productRepository->getById($productId);
        return view('Front::singleProduct', compact('product', 'ads'));
    }

    public function extractId($slug, $key)
    {
        return Str::before(Str::after($slug, $key . '-'), '-');
    }

    public function singleArticle($slug, ArticleRepository $articleRepo)
    {
        $ads = Ads::accepted()->where('page', 'single-article')->get();
        $article = Str::before(Str::after($slug, 'c1-'), '-');
        $article = $articleRepo->getById($article);
        $article->increment('viewCount');
        return view('Front::singleArticle', compact('article', 'ads'));
    }

    public function productComment(Product $product, Request $request)
    {
        $product->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
        ]);
        return response()->json(['success' => 'عملیات با موفقیت انجام شد']);
    }

    public function singleTutor($username)
    {
        $tutor = User::permission(Permission::PERMISSION_SELL)->where('username', $username)->first();
        return view('Front::tutor', compact('tutor'));
    }

    public function setting()
    {
        $settings = Setting::all();
        return view('Front::layout.contact-us', compact('settings'));
    }

    public function seller()
    {
        return view('Front::seller');
    }

    public function singleStore(Request $request)
    {
        $this->seller($request, [
            'name' => 'required',
            'nationalCode' => 'required',
            'email' => 'required|email',
            'mobile' => ['required', 'string', 'max:14', 'unique:users', new ValidMobile()],
            'shop' => 'required',
            'telegram' => 'nullable',
            'products' => 'required',
            'Address' => 'required',
        ]);
        Mail::send('Sellers::message', [
            'msg' => $request->message
        ], function ($mail) use ($request) {
            $mail->from($request->email, $request->name);
            $mail->to('test@yahoo.com')->subject('Seller Message');
        });
        return redirect()->back()->with('flash_message',
            'درخواست همکاری شما با موفقیت ارسال شد. پس از تایید مدیریت سایت با شما تماس گرفته خواهد شد.');
    }
}

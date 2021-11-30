<?php

namespace Milano\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Milano\Article\Http\Requests\ArticleRequest;
use Milano\Article\Http\Requests\GetAllRequest;
use Milano\Article\Models\Article;
use Milano\Article\Repositories\Interfaces\ArticleRepositoryInterface;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;

class ArticleController extends Controller
{
    protected ArticleRepositoryInterface $article_repository;
    protected CategoryRepositoryInterface $category_repository;

    public function __construct(ArticleRepositoryInterface $article_repository,
                                CategoryRepositoryInterface $category_repository)
    {
        $this->article_repository = $article_repository;
        $this->category_repository = $category_repository;
    }

    public function index(GetAllRequest $request)
    {
        $category_id = [];
        $input = $request->only(['title', 'category_id']);
        $categories = $this->category_repository->getAll($category_id);
        $articles = $this->article_repository->paginate($input);
        $this->authorize('index', $articles);
//        return Article::with('category')->simplePaginate();
        return view('Articles::index', compact('articles', 'categories'));
    }

    public function create()
    {
        $category_id = [];
        $categories = $this->category_repository->getAll($category_id);
        $article = $this->article_repository->getAll();
        $this->authorize('create', $article);
        return view('Articles::create', compact('article', 'categories'));
    }

    public function store(ArticleRequest $request)
    {
        $input = $request->only(['title', 'slug', 'body']);
        $result = $this->article_repository->store($input);
        $categories = $this->article_repository->storeCategory($input,$request->category_id);
//        $article->categories()->sync($request->category_id);
        if (!$result) {
            return redirect()->back()->with('error', 'ایجاد محصول با مشکل مواجه شد');
        }
        return redirect()->route('articles.index', 'categories')->with('success', 'محصول جدید با موفقیت ایجاد شد');
    }






}

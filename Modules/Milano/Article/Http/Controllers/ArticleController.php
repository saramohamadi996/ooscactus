<?php

namespace Milano\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Milano\Article\Http\Requests\ArticleRequest;
use Milano\Article\Http\Requests\GetAllRequest;
use Milano\Article\Models\Article;
use Milano\Article\Repositories\Interfaces\ArticleRepositoryInterface;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Symfony\Component\Console\Input\Input;

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
        $input = $request->only(['title','slug','body', 'user_id', 'category_id', 'image']);
        $result = $this->article_repository->store($input);
        if (!$result) {
            return redirect()->back()->with('error', 'ایجاد مقاله با مشکل مواجه شد');
        }
        return redirect()->route('articles.index')->with('success', 'مقاله جدید با موفقیت ایجاد شد');
    }

}

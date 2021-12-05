<?php

namespace Milano\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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

    public function edit($id)
    {
        $category_id = [];
        $article = $this->article_repository->getById($id);
        $categories = $this->category_repository->getAll($category_id);
        $this->authorize('edit', $article);
        return view('Articles::edit', compact('article', 'categories'));
    }

    public function store(ArticleRequest $request)
    {
        $input = $request->only(['title', 'slug', 'body', 'user_id', 'category_id', 'image']);
        if ($request->has('image')) {
            try {
                $input['image'] = $request->file('image')->store('article', 'public');
            } catch (QueryException $query_exception) {
                Log::error($query_exception->getMessage());
            }
        }
        $result = $this->article_repository->store($input);
        if (!$result) {
            return redirect()->back()->with('error', 'ایجاد مقاله با مشکل مواجه شد');
        }
        return redirect()->route('articles.index')->with('success', 'مقاله جدید با موفقیت ایجاد شد');
    }

    public function update(ArticleRequest $update, int $id)
    {
        $article = $this->article_repository->getById($id);
        $input = $update->only(['title', 'slug', 'body', 'user_id', 'category_id', 'image', 'is_enabled']);
        if ($update->has('image')) {
            try {
                Storage::disk('public')->delete($article->image);
                $input['image'] = $update->file('image')->store('article', 'public');
            }catch (QueryException $queryException){
                Log::error($queryException->getMessage());
            }
        } else {
            $input['image'] = $article->image;
        }
        $result = $this->article_repository->update($input, $article);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات  بروزرسانی با شکست مواجه شد.');
        }
        return redirect()->route('articles.index')
            ->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    public function toggle(int $id)
    {
        dd('dasd');
        $article = $this->article_repository->getById($id);
        $input = ['is_enabled' => !$article->is_enabled];
        $result = $this->article_repository->update($input, $article);
        if (!$result) {
            return redirect()->back()->with('error', 'فعالسازی با مشکل مواجه شد');
        }
        return redirect()->back()->with('success', 'فعال شد');
    }

    public function destroy(int $id)
    {
        $article = $this->article_repository->getById($id);
        $this->authorize('delete', $article);
        try {
            Storage::disk('public')->delete($article->image);
        } catch (QueryException | \Exception $ex) {
            Log::error($ex->getMessage());
        }
        $result = $this->article_repository->delete($article);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات حذف با شکست مواجه شد.');
        }
        return redirect()->back()->with('success', 'عملیات حذف با موفقیت انجام شد.');
    }



}

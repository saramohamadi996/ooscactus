<?php

namespace Milano\Article\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Milano\Article\Http\Requests\ArticleStoreRequest;
use Milano\Article\Http\Requests\GetAllRequest;
use Milano\Article\Models\Article;
use Milano\Article\Repositories\Interfaces\ArticleRepositoryInterface;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Symfony\Component\Console\Input\Input;

class ArticleController extends Controller
{
    /**
     * The article repository instance.
     * @var ArticleRepositoryInterface
     */
    protected ArticleRepositoryInterface $article_repository;

    /**
     * The category repository instance.
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $category_repository;

    /**
     * ArticleController constructor.
     * @param ArticleRepositoryInterface $article_repository
     * @param CategoryRepositoryInterface $category_repository
     */
    public function __construct(ArticleRepositoryInterface $article_repository,
                                CategoryRepositoryInterface $category_repository)
    {
        $this->article_repository = $article_repository;
        $this->category_repository = $category_repository;
    }

    /**
     * Display a listing of the resource.
     * @param GetAllRequest $request
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(GetAllRequest $request): View
    {
        $category_id = [];
        $input = $request->only(['title', 'category_id']);
        $categories = $this->category_repository->getAll($category_id);
        $articles = $this->article_repository->paginate($input);
        $this->authorize('index', $articles);
        return view('Articles::index', compact('articles', 'categories'));
    }

    /**
     * Show the form for create the specified resource.
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $category_id = [];
        $categories = $this->category_repository->getAll($category_id);
        $article = $this->article_repository->getAll();
        $this->authorize('create', $article);
        return view('Articles::create', compact('article', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit($id): View
    {
        $category_id = [];
        $article = $this->article_repository->getById($id);
        $categories = $this->category_repository->getAll($category_id);
        $this->authorize('edit', $article);
        return view('Articles::edit', compact('article', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param ArticleStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleStoreRequest $request): RedirectResponse
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

    /**
     *  Update the specified resource in storage.
     * @param ArticleStoreRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ArticleStoreRequest $request, int $id): RedirectResponse
    {
        $article = $this->article_repository->getById($id);
        $input = $request->only(['title', 'slug', 'body', 'user_id', 'category_id', 'image', 'is_enabled']);
        if ($request->has('image')) {
            try {
                Storage::disk('public')->delete($article->image);
                $input['image'] = $request->file('image')->store('article', 'public');
            } catch (QueryException $queryException) {
                Log::error($queryException->getMessage());
            }
        } else {
            $input['image'] = $article->image;
        }

        $result = $this->article_repository->update($input, $article );
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات  بروزرسانی با شکست مواجه شد.');
        }
        return redirect()->route('articles.index')
            ->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    /**
     * enable article
     * @param int $id
     * @return RedirectResponse
     */
    public function toggle(int $id)
    {
        $article = $this->article_repository->getById($id);
        $input = ['is_enabled' => !$article->is_enabled];
        $result = $this->article_repository->update($input, $article);
        if (!$result) {
            return redirect()->back()->with('error', 'فعالسازی با مشکل مواجه شد');
        }
        return redirect()->back()->with('success', 'فعال شد');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
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

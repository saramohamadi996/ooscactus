<?php

namespace Milano\Article\Http\Controllers;
use Illuminate\Http\Request;
use Milano\Article\Repositories\ArticleRepo;
use Milano\Category\Repositories\CategoryRepo;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Milano\Article\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Storage;
use Milano\Common\Responses\AjaxResponses;

class ArticleController extends Controller
{
    public $repo;
    public $categoryRepo;
    public function __construct(ArticleRepo $articleRepo, CategoryRepo $categoryRepo)
    {
        $this->repo = $articleRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        $categories = $this->repo;
        $articles = $this->repo
            ->searchCategoryId($request->category_id)
            ->searchTitle($request->title)->paginate();
        $this->authorize('index', $articles);
        return view('Articles::index' , compact('articles'));
    }

    public function create(CategoryRepo $categoryRepo)
    {
        $categories = $this->repo;
        $categories = $this->categoryRepo->all();
        return view('Articles::create' , compact('categories'));
    }

    public function store(ArticleRequest $request)
    {
        $article = $this->repo->store($request);
        $article->categories()->sync($request->category_id);
        $this->authorize('store', $article);
        return redirect(route('articles.index'));
    }

    public function edit($id, CategoryRepo $categoryRepo)
    {
        $article = $this->repo->findByid($id);
        $this->authorize('edit', $article);
        $categories = $categoryRepo;
        return view('Articles::edit' , compact('categories' , 'article'));
    }

    public function update($id, ArticleRequest $request)
    {
        $article = $this->repo->update($id, $request);
        $this->authorize('edit', $article);
        return redirect(route('articles.index'));
    }

    public function destroy($id)
    {
        $article = $this->repo->findByid($id);
        $this->authorize('delete', $article);
        $article->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function accept($id)
    {
        $article = $this->repo->accept($id);
        $this->authorize('change_confirmation_status', $article);
    }

    public function reject($id)
    {
        $article = $this->repo->reject($id);
        $this->authorize('change_confirmation_status', $article);
    }
}

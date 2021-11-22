<?php

namespace Milano\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Milano\Category\Http\Requests\CategoryRequest;
use Milano\Category\Models\Category;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * The category repository instance.
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $category_repository;

    /**
     * Instantiate a new category instance.
     * @param CategoryRepositoryInterface $category_repository
     */
    public function __construct(CategoryRepositoryInterface $category_repository)
    {
        $this->category_repository = $category_repository;
    }

    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $this->authorize('manage', Category::class);
        $categories = $this->category_repository->paginate();
        return view('Categories::index', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $category_id = $this->category_repository->findById($id);
        $category = $this->category_repository->getAll($category_id);
        return view('Categories::edit', compact('category', 'category'));
    }


    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request):RedirectResponse
    {
        $input = $request->only('title', 'slug', 'parent_id');
        $result = $this->category_repository->store($input);
        if (!$result){
            return redirect()->back()->with('error', 'عملیات ذخیره سازی با شکست مواجه شد.');
        }
        return back()->with('success', 'عملیات ذخیره سازی با موفقیت انجام شد.');
    }


    /**
     * Update the specified resource in storage.
     * @param  CategoryRequest $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update(int $id, CategoryRequest $request):RedirectResponse
    {
        $category = $this->category_repository->findById($id);
        $input = $request->only('title', 'slug', 'parent_id');
        $result = $this->category_repository->update($input, $category);
        if (!$result){
            return redirect()->back()->with('error', 'عملیات بروزرسانی با شکست مواجه شد.');
        }
        return redirect()->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id):RedirectResponse
    {
        $category = $this->category_repository->findById($id);
        $result = $this->category_repository->delete($category);
        if (!$result){
            return redirect()->back()->with('error', 'عملیات حذف با شکست مواجه شد.');
        }
        return redirect()->back()->with('success', 'عملیات حذف با موفقیت شد.');
    }
}

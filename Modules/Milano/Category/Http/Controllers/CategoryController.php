<?php

namespace Milano\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Milano\Category\Http\Requests\CategoryStoreRequest;
use Milano\Category\Http\Requests\CategoryUpdateRequest;
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
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('manage', Category::class);
        $categories = $this->category_repository->paginate();
        return view('Categories::index', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $category_id
     * @return View
     * @throws AuthorizationException
     */
    public function edit(int $category_id): View
    {
        $this->authorize('edit', Category::class);
        $category = $this->category_repository->findById($category_id);
        $categories = $this->category_repository->getAll($category_id);
        return view('Categories::edit', compact('category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $input = $request->only('title', 'slug', 'parent_id');
        $result = $this->category_repository->store($input);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات ذخیره سازی با شکست مواجه شد.');
        }
        return back()->with('success', 'عملیات ذخیره سازی با موفقیت انجام شد.');
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param CategoryUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, CategoryUpdateRequest $request): RedirectResponse
    {
        $category = $this->category_repository->findById($id);
        $input = $request->only('title', 'slug', 'parent_id');
        $result = $this->category_repository->update($input, $category);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات بروزرسانی با شکست مواجه شد.');
        }
        return redirect()->route('categories.index')->with('success', 'عملیات بروزرسانی با موفقیت انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorize('destroy', Category::class);
        $category = $this->category_repository->findById($id);
        $result = $this->category_repository->delete($category);
        if (!$result) {
            return redirect()->back()->with('error', 'عملیات حذف با شکست مواجه شد.');
        }
        return redirect()->back()->with('success', 'عملیات حذف با موفقیت شد.');
    }
}

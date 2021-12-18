<?php

namespace Milano\Category\Repositories;

use Illuminate\Support\Str;
use Milano\Category\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Milano\Category\Models\Category;
use Milano\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * fetch query builder categories.
     * @return Builder|mixed
     */
    private function fetchQueryBuilder(): Builder
    {
        return Category::query();
    }

    /**
     * paginate categories.
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function paginate(int $per_page = 10): LengthAwarePaginator
    {
        return $this->fetchQueryBuilder()->paginate();
    }

    /**
     * Get the value from the database.
     * @param $id
     * @return Collection|Category[]
     */
    public function getAll($id):Collection
    {
        return Category::all()->filter(function ($item) use ($id) {
            return $item->id != $id;
        });
    }

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Builder|Category
     */
    public function getById(int $id):Category
    {
        return $this->fetchQueryBuilder()->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @return bool
     */
    public function store(array $value): bool
    {
        $category = new Category();
        $category->title = $value['title'];
        $category->slug = Str::slug($value['slug']);
        $category->parent_id = $value['parent_id'];
        try {
            $category->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Category $category
     * @return bool
     */
    public function update(array $value, Category $category): bool
    {
        $category->title = $value['title'];
        $category->slug = $value['slug'];
        $category->parent_id = $value['parent_id'];
        try {
            $category->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return bool
     * @throws \Exception
     */
    public function delete(Category $category): bool
    {
        try {
            $category->delete();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    //
    public function tree()
    {
        return Category::where('parent_id', null)->with('subCategories')->get();
    }

    public function latestProducts()
    {
        return Product::where('is_enabled', '=', 1)->latest()->take(8)->get();
    }
}

<?php

namespace Milano\Category\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Milano\Category\Models\Category;

interface CategoryRepositoryInterface
{
    public function tree();

    public function latestProducts();

    /**
     * paginate categories.
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function paginate(int $per_page = 10): LengthAwarePaginator;

    /**
     * Get the value from the database.
     * @param $id
     * @return Collection|Category[]
     */
    public function getAll($id): Collection;

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Builder|Category
     */
    public function getById(int $id): Category;

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @return bool
     */
    public function store(array $value): bool;

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Category $category
     * @return bool
     */
    public function update(array $value, Category $category): bool;

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return bool
     */
    public function delete(Category $category): bool;

}

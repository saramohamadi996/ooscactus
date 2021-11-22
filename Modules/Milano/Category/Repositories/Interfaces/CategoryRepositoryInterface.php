<?php

namespace Milano\Category\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Milano\Category\Models\Category;

interface CategoryRepositoryInterface
{
    public function tree();

    public function latestProducts();

    /**
     * paginate categories.
     * @param int $perpage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perpage = 10): LengthAwarePaginator;

    /**
     * Get the value from the database.
     * @return mixed
     */
    public function getAll($d): Collection;

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Category
     */
    public function findById(int $id): Category;

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

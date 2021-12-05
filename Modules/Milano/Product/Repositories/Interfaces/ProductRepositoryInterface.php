<?php

namespace Milano\Product\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Milano\Product\Models\Product;

interface ProductRepositoryInterface
{
    public function getProductsBySellerId(int $id);

    /**
     * paginate products.
     * @param array $input
     * @param int $per_page
     * @return Paginator
     */
    public function paginate(array $input = [], int $per_page = 10): paginator;

    /**
     * find by id the record with the given id.
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * find by id the record with the given id.
     * @return Builder|Builder[]|Collection|Model|Product
     */
    public function getById(int $id): Product;

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @param $images
     * @return bool
     */
    public function store(array $value, $images):bool;

    /**
     * Update the specified resource in storage.
     * @param array $values
     * @param int $id
     * @return bool
     */
    public function update(array $values, Product $product):bool;

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return bool
     */
    public function delete(Product $product): bool;
}

<?php

namespace Milano\Product\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Milano\Product\Models\Product;

interface ProductRepositoryInterface
{
    /**
     * paginate products.
     * @param array $input
     * @param int $per_page
     * @return Paginator
     */
    public function paginate(array $input = [], int $per_page = 10): paginator;

    /**
     * find by id the record with the given id.
     * @param $id
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Builder|Product
     */
    public function findById(int $id): Product;

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @return bool
     */
    public function store(array $value): bool;

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Product $product
     * @return bool
     */
    public function update(array $value, Product $product): bool;

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product): bool;

    public function updateConfirmationStatus($product);

    public function latestProducts();

    public function accept($id);

    public function reject($id);

    public function getProductsBySellerId(?int $id);

    public function getSellers($userId);
}

<?php

namespace Milano\Product\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Milano\Product\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * fetch query builder products.
     *
     * @param $input
     * @return Builder|mixed
     */
    private function fetchQueryBuilder(array $input = []): Builder
    {
        return Product::query()
            ->when(isset($input['title']), function (Builder $query) use ($input) {
                $query->where('title', '=', $input['title']);
            })
            ->when(isset($input['code_product']), function (Builder $query) use ($input) {
                $query->where('code_product', '=', $input['code_product']);
            })
            ->when(isset($input['price']), function (Builder $query) use ($input) {
                $query->where('price', '=', $input['price']);
            })
            ->when(isset($input['priority']), function (Builder $query) use ($input) {
                $query->where('priority', '=', $input['priority']);
            })
            ->when(isset($input['seller_id']), function (Builder $query) use ($input) {
                $query->where('seller_id', '=', $input['seller_id']);
            })
            ->when(isset($input['category_id']), function (Builder $query) use ($input) {
                $query->where('category_id', '=', $input['category_id']);
            });
    }

    /**
     * paginate products.
     * @param array $input
     * @param int $per_page
     * @return Paginator
     */
    public function paginate(array $input = [], int $per_page = 10): paginator
    {
        return $this->fetchQueryBuilder($input)->paginate($per_page);
    }

    /**
     * find by id the record with the given id.
     * @param $id
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->fetchQueryBuilder()->get();
    }

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Builder|Product
     */
    public function findById(int $id): Product
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
        $product = new Product();
        $product->seller_id = $value['seller_id'];
        $product->category_id = $value['category_id'];
        $product->title = $value['title'];
        $product->meta_description = $value['meta_description'];
        $product->slug = Str::slug($value['slug']);
        $product->priority = $value['priority'];
        $product->price = $value['price'];
        $product->seller_share = $value['seller_share'];
        $product->body = $value['body'];
        $product->image = $value['image'];
        $product->stock = $value['stock'];
        $product->code_product = $value['code_product'];
        $product->confirmation_status = Product::CONFIRMATION_STATUS_PENDING;
        try {
            $product->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Update the specified resource in storage.
     * @param array $value
     * @param Product $product
     * @return bool
     */
    public function update(array $value, Product $product): bool
    {
        $product->seller_id = $value['seller_id'];
        $product->category_id = $value['category_id'];
        $product->title = $value['title'];
        $product->meta_description = $value['meta_description'];
        $product->slug = Str::slug($value['slug']);
        $product->priority = $value['priority'];
        $product->price = $value['price'];
        $product->seller_share = $value['seller_share'];
        $product->body = $value['body'];
        $product->image = $value['image'];

        $product->stock = $value['stock'];
//        $product->code_product = $value['code_product'];
        $product->confirmation_status = Product::CONFIRMATION_STATUS_PENDING;
        try {
            dd($product);
            $product->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(Product $product): bool
    {
        try {
            $product->delete();
        } catch (QueryException $queryException) {
            Log::error($queryException->getMessage());
            return false;
        }
        return true;
    }


    public function updateConfirmationStatus($product)
    {
        $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_ACCEPTED]);
        return $product;
    }

    public function latestProducts()
    {
        return Product::where('confirmation_status', Product::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(8)->get();
    }

    public function accept($id)
    {
        $product = $this->findByid($id);
        return $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_ACCEPTED]);
    }

    public function reject($id)
    {
        $product = $this->findByid($id);
        return $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_REJECTED]);
    }

    public function getProductsBySellerId(?int $id)
    {
        return Product::where('seller_id', $id)->get();
    }

    public function getSellers($userId)
    {
        return Product::where('seller_id', $userId)->get();
    }
}

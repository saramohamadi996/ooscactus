<?php

namespace Milano\Product\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Milano\Product\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Milano\Product\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getProductsBySellerId(int $id)
    {
        return Product::where('seller_id', $id)->get();
    }

    /**
     * fetch query builder products.
     * @param array $input
     * @return Builder
     */
    private function fetchQueryBuilder(array $input = []): Builder
    {
        return Product::query()
            ->when(isset($input['title']), function (Builder $query) use ($input) {
                $query->orWhere('title', 'like', '%' . $input['title'] . '%');
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
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->fetchQueryBuilder()->get();
    }

    /**
     * find by id the record with the given id.
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|Product
     */
    public function getById(int $id): Product
    {
        return $this->fetchQueryBuilder()->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $value
     * @param $images
     * @return bool
     */
    public function store(array $value, $images): bool
    {
        $product = Product::create([
            'seller_id' => $value['seller_id'],
            'category_id' => $value['category_id'],
            'title' => $value['title'],
            'meta_description' => $value['meta_description'],
            'slug' => Str::slug($value['slug']),
            'priority' => $value['priority'],
            'price' => $value['price'],
            'seller_share' => $value['seller_share'],
            'body' => $value['body'],
            'stock' => $value['stock'],
            'code_product' => $value['code_product'],
        ]);
        if (isset($images[0])) {
            foreach ($images as $key => $image) {
                $product->image = $images[0];
            }
        }
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
     * @param int $id
     * @return bool
     */
    public function update(array $value, Product $product): bool
    {
        if (isset($value['status'])) {
            $product->status = $value['status'];
        }
        if (isset($value['is_enabled'])) {
            $product->is_enabled = $value['is_enabled'];
        }
        if (isset($value['seller_id'])) {
            $product->seller_id = $value['seller_id'];
        }
        if (isset($value['category_id'])) {
            $product->category_id = $value['category_id'];
        }
        if (isset($value['title'])) {
            $product->title = $value['title'];
        }
        if (isset($value['meta_description'])) {
            $product->meta_description = $value['meta_description'];
        }
//        if (isset($value['slug'])) {
//            $product->slug = Str::slug($value['slug']);
//        }
        if (isset($value['priority'])) {
            $product->priority = $value['priority'];
        }
        if (isset($value['price'])) {
            $product->price = $value['price'];
        }
        if (isset($value['seller_share'])) {
            $product->seller_share = $value['seller_share'];
        }
        if (isset($value['body'])) {
            $product->body = $value['body'];
        }
        if (isset($value['stock'])) {
            $product->stock = $value['stock'];
        }
        if (isset($value['code_product'])) {
            $product->code_product = $value['code_product'];
        }
        if (isset($mainPicture)) {
            $product->image = $mainPicture;
        }
        try {
            $product->save();
        } catch (QueryException $queryException) {
            Log::error($queryException->getmessage());
            return false;
        }
        return true;
    }

    /**
     * Remove the specified resource from storage.
     * @param Product $product
     * @return bool
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

//    public function updateConfirmationStatus($id)
//    {
//        $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_ACCEPTED]);return $product;
//    }
//    public function latestProducts()
//    {
//        return Product::where('confirmation_status', Product::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(8)->get();
//    }
//    public function accept($id)
//    {
//        $product = $this->findByid($id);
//        return $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_ACCEPTED]);
//    }
//    public function reject($id)
//    {
//        $product = $this->findByid($id);
//        return $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_REJECTED]);
//    }
}

<?php
namespace Milano\Product\Repositories;
use Milano\Product\Models\ImageProduct;
use Milano\Product\Models\Product;
use Illuminate\Support\Str;
use Milano\User\Models\User;

class ProductRepo
{
    private $findByid;
    private $query;
    public function __construct()
    {
        $this->query = Product::query();
    }
    public function findByid($id)
    {
        return Product::findOrFail($id);
    }
    public function all(){
        return Product::all();
    }

    public function getSellers($userId)
    {
        return Product::where('seller_id' , $userId)->get();
    }
    public function searchTitle($title)
    {
        if (!is_null($title)) {
            $this->query->where("title", "like", "%" .  $title . "%");
        }return $this;
    }
   public function searchCodeProduct($CodeProduct)
    {
        if (!is_null($CodeProduct)) {
            $this->query->where("code_product", "like", "%" .  $CodeProduct . "%");
        }return $this;
    }

    public function searchPrice($price)
    {
        if (!is_null($price)) {
            $this->query->where("price", $price);
        }return $this;
    }

    public function searchPriority($priority)
    {
        if (!is_null($priority)) {
            $this->query->where("priority", $priority);
        }return $this;
    }
    public function paginate()
    {
        return $this->query->latest()->paginate();
    }
    public function getProductsBySellerId(?int $id)
    {
        return Product::where('seller_id', $id)->get();
    }
    public function store($values)
    {
        $images = [];
        if ($values->hasFile('images')) {
            foreach ($values->images as $image) {
                $images[] = $image->store("photos/product/", 'public');
            }
        }
        $product =  Product::create([
            'seller_id' => $values->seller_id,
            'category_id' => $values->category_id,
            'title' => $values->title,
            'meta_description' => $values->meta_description,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'seller_share' => $values->seller_share,
            'body' => $values->body,
            'image' => $images[0] ?? null,
            'stock' => $values->stock,
            'code_product' => $values->code_product,
            'confirmation_status' => Product::CONFIRMATION_STATUS_PENDING,
        ]);
        foreach ($images as $key => $image) {
            $product->images()->create(['src' => $image, 'main_image' => $key == 0]);
        }
//        $product->tags()->create(['tags' => $values->tags,]);
        return $product;
    }

    public function update($values , $id)
    {
        $product = Product::where('id' , $id)->firstOrFail();
        if ($values->hasFile('images')) {
            foreach ($values->images as $image) {
                $product->images()->create([
                    'src' => $image->store("photos/Product/", 'public'),
                    'main_image' => 0
                ]);
            }
        }
        if ($product->image != $values->main_image) {
            foreach ($product->images as $image) {
                $image->update([
                    'main_image' => $values->main_image == $image->src ? 1 : 0
                ]);
            }
            $mainPicture = $values->main_image;
        }
          $product->update([
        'seller_id' => $values->seller_id,
        'category_id' => $values->category_id,
        'title' => $values->title,
        'meta_description' => $values->meta_description,
         'slug' => Str::slug($values->slug),
        'priority' => $values->priority,
        'price' => $values->price,
        'seller_share' => $values->seller_share,
        'status' => $values->status,
        'body' => $values->body,
        'image' => $mainPicture ??   $product->image,
        'stock' => $values->stock,
        'code_product' => $values->code_product,
        ]);
    return $product;
    }
    public function updateConfirmationStatus($product)
    {
         $product->update(['confirmation_status' => Product::CONFIRMATION_STATUS_ACCEPTED]);return $product;
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
}

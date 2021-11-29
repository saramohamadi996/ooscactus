<?php

namespace Milano\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    protected $table = 'image_products';

    protected $fillable = ['product_id', 'src', 'main_image'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id');
    }
}

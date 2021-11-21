<?php
namespace Milano\Product\Models;
use Illuminate\Database\Eloquent\Model;
use Milano\Product\Models\Product;

class Tag extends Model
{
    protected $fillable = ['tags' , 'tag_id' , 'taggable_type' , 'taggable_type'];

    protected $casts = [
        'tags' => 'string'
    ];

    public function products()
    {
        return $this->morphByMany(Product::class , 'taggable');
    }
}


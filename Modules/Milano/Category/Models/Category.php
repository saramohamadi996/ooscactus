<?php
namespace Milano\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Milano\Article\Models\Article;
use Milano\Coupon\Models\Coupon;
use Milano\Product\Models\Product;

class Category extends  Model
{
protected $guarded= [];

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getParentAttribute()
    {
        return (is_null($this->parent_id)) ? 'ندارد' : $this->parentCategory->title;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function path()
    {
        return route('allProducts.product' , 'category' . '=' . $this->slug);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function coupons()
    {
        return $this->morphToMany(Coupon::class , 'couponable');
    }


}

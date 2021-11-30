<?php

namespace Milano\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Milano\Article\Models\Article;
use Milano\Coupon\Models\Coupon;
use Milano\Product\Models\Product;

/**
 * Class Category
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $parent_id
 * @package Milano\Category\Models
 */
class Category extends Model
{
    /**
     * define Category's table.
     * @var string
     */
    protected $table = 'categories';

    /**
     * category if the model should be timestamped.
     * @var bool
     */
    public $timestamps = false;

    /**define Category's fallible fields.
     * @var string[]
     */
    protected $fillable = ['title', 'slug', 'parent_id'];

    /**
     * define Category's casts
     * @var string[]
     */
    protected $casts = ['parent_id' => 'integer', 'title' => 'string', 'slug' => 'string'];

    /**
     * Get the parent category that owns the category.
     * @return BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get all of the sub category for the category.
     * @return HasMany
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * title accessor
     * @return string
     */
    public function getParentAttribute()
    {
        return (is_null($this->parent_id)) ? 'ندارد' : $this->parentCategory->title;
    }

    /**
     * Get all of the products for the category
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return string
     */
    public function path()
    {
        return route('allProducts.product', 'category' . '=' . $this->slug);
    }

    /**
     * Get all of the articles for the category
     * @return BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class,
            'article_categories', 'article_id', 'category_id');
    }


}

<?php

namespace Milano\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Milano\Category\Models\Category;
use Milano\User\Models\User;
use Illuminate\Support\Str;
use Hekmatinasser\Verta\Verta;

/**
 * Class Article
 * @property int $user_id
 * @property int $category_id
 * @property string $image
 * @property string $title
 * @property string $slug
 * @property boolean $is_enabled
 * @property string $body
 * @package Milano\Article\Models
 */
class Article extends Model
{
    /**
     * define Category's table.
     * @var string
     */
    protected $table = 'articles';

    /**
     * define Category's fallible fields.
     * @var string[]
     */
    protected $fillable = ['user_id', 'title', 'slug', 'body', 'image',
        'category_id', 'status', 'is_enabled', 'viewCount', 'commentCount'];

    /**
     * define Category's casts.
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'body' => 'string',
        'image' => 'string',
        'category_id' => 'integer',
        'status' => 'boolean',
        'is_enabled' => 'boolean',
        'viewCount' => 'integer',
        'commentCount' => 'integer',
    ];

    /**
     * Get the user for the article.
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The articles that belong to the categories.
     * @return BelongsToMany
     */
    public function categories():BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }

    /**
     * Arrange the display of the latest articles according to the creation date.
     * @return mixed
     */
    public function latestArticle()
    {
        return $this->where('is_enabled')->orderBy('created_at')->latest()->take(3)->get();
    }

    /**
     * limit char body.
     * @return string
     */
    public function limitCharBody():string
    {
        return Str::words($this->body, 30, '...');
    }

    /**
     * limit char title.
     * @return string
     */
    public function limitCharTitle():string
    {
        return Str::limit($this->title, 25, '...');
    }

    /**
     * Display an article path using id  and slug.
     * @return string
     */
    public function path():string
    {
        return route('singleArticle', $this->id . '-' . $this->slug);
    }

    /**
     * Short article path link using article ID.
     * @return string
     */
    public function shortUrl():string
    {
        return route('singleArticle', $this->id);
    }

    /**
     * get jalali created at attribute
     * @return mixed
     */
    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatJalaliDate();
    }
}


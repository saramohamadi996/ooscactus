<?php

namespace Milano\Article\Models;

use Illuminate\Database\Eloquent\Model;
use Milano\Category\Models\Category;
use Milano\Comment\Models\Comment;
use Milano\Media\Models\Media;
use Milano\User\Models\User;
use Illuminate\Support\Str;
use Hekmatinasser\Verta\Verta;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = ['user_id', 'title', 'slug', 'body', 'image', 'is_enabled', 'viewCount', 'commentCount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,
            'article_categories', 'article_id', 'category_id');

    }

    public function latestArticle()
    {
        return $this->where('is_enabled')->orderBy('created_at')->latest()->take(3)->get();
    }

    public function limitCharBody()
    {
        return Str::words($this->body, 30, '...');
    }

    public function limitCharTitle()
    {
        return Str::limit($this->title, 25, '...');
    }

    public function path()
    {
        return route('singleArticle', $this->id . '-' . $this->slug);
    }

    public function shortUrl()
    {
        return route('singleArticle', $this->id);
    }

    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatJalaliDate();
    }
}


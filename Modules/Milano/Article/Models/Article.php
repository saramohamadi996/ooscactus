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
    protected $guarded = [];
    protected $table = 'articles';

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses =
    [self::CONFIRMATION_STATUS_ACCEPTED,
    self::CONFIRMATION_STATUS_PENDING,
    self::CONFIRMATION_STATUS_REJECTED];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function latestArticle()
    {
        return $this->where('confirmation_status' , self::CONFIRMATION_STATUS_PENDING)
            ->orderBy('created_at')->latest()->take(3)->get();
    }

    public function limitCharBody()
    {
        return Str::words($this->body,  30 , '...' );
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


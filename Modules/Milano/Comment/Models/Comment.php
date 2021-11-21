<?php

namespace Milano\Comment\Models;

use Illuminate\Support\Str;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;
use Milano\User\Models\User;

class Comment extends Model
{
    protected $guarded = [];
    protected $table = 'comments';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses =
        [self::CONFIRMATION_STATUS_ACCEPTED,
            self::CONFIRMATION_STATUS_PENDING,
            self::CONFIRMATION_STATUS_REJECTED];
//    public function commentable()
//    {
//        return $this->morphTo();
//    }

//    public function child()
//    {
//        return $this->hasMany(Comment::class , 'parent_id');
//    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatDifference();
    }

    public function limitCharBody()
    {
        return Str::words($this->body, 30, '...');
    }
}

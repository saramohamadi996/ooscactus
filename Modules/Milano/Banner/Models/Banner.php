<?php
namespace Milano\Banner\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $guarded = [];
    protected $table = 'banners';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses =
        [self::CONFIRMATION_STATUS_ACCEPTED,
            self::CONFIRMATION_STATUS_PENDING,
            self::CONFIRMATION_STATUS_REJECTED];


//    public function latestBanner()
//    {
//        return $this->where('status' , self::CONFIRMATION_STATUS_PENDING)
//            ->orderBy('created_at')->latest()->take(3)->get();
//    }

    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatJalaliDate();
    }
}

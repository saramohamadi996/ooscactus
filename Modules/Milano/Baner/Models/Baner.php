<?php
namespace Milano\Baner\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Baner extends Model
{
    protected $guarded = [];
    protected $table = 'baners';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses =
        [self::CONFIRMATION_STATUS_ACCEPTED,
            self::CONFIRMATION_STATUS_PENDING,
            self::CONFIRMATION_STATUS_REJECTED];


    public function latestBaner()
    {
        return $this->where('status' , self::CONFIRMATION_STATUS_PENDING)
            ->orderBy('created_at')->latest()->take(3)->get();
    }

    public function getJalaliCreatedAtAttribute()
    {
        $v = new Verta($this->created_at);
        return $v->formatJalaliDate();
    }
}

<?php
namespace Milano\Ads\Models;

use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $guarded = [];
    protected $table = 'adss';

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED,
        self::CONFIRMATION_STATUS_PENDING,
        self::CONFIRMATION_STATUS_REJECTED];

    const PAGE_HOME = 'home';
    const PAGE_SINGLE_PRODUCT = 'single-product';
    const PAGE_SINGLE_ARTICLE = 'single-article';
    static $pages = [self::PAGE_HOME, self::PAGE_SINGLE_PRODUCT, self::PAGE_SINGLE_ARTICLE];

    const ADS_NEW_TAB = 'new-tab';
    const ADS_POP_UP = 'pop-ap';
    const ADS_BANNER = 'banner';
    static $adss = [self::ADS_NEW_TAB,self::ADS_BANNER,self::ADS_POP_UP];


    const OPENING_ALWAYS_ACTIVE = 'always-active';
    const OPENING_ONE_TIME_PER_DAY = 'one-time-per-day';
    const OPENING_TWO_TIME_PER_DAY = 'two-time-per-day';
    const OPENING_THREE_TIME_PER_DAY = 'three-time-per-day';
    const OPENING_FOUR_TIME_PER_DAY = 'four-time-per-day';
    const OPENING_FIVE_TIME_PER_DAY = 'five-time-per-day';
    const OPENING_SIX_TIME_PER_DAY = 'six-time-per-day';
    const OPENING_SEVEN_TIME_PER_DAY = 'seven-time-per-day';
    const OPENING_EIGHT_TIME_PER_DAY = 'eight_time_per_day';
    const OPENING_NIN_TIME_PER_DAY = 'nin-time-per-day';
    const OPENING_TEN_TIME_PER_DAY = 'ten-time-per-day';
    static $openings = [self::OPENING_ALWAYS_ACTIVE,
        self::OPENING_ONE_TIME_PER_DAY, self::OPENING_TWO_TIME_PER_DAY,
        self::OPENING_THREE_TIME_PER_DAY, self::OPENING_FOUR_TIME_PER_DAY,
        self::OPENING_FIVE_TIME_PER_DAY, self::OPENING_SIX_TIME_PER_DAY,
        self::OPENING_SEVEN_TIME_PER_DAY, self::OPENING_EIGHT_TIME_PER_DAY,
        self::OPENING_NIN_TIME_PER_DAY, self::OPENING_TEN_TIME_PER_DAY];

    public function scopeAccepted($query)
    {
        return $query->where('confirmation_status', static::CONFIRMATION_STATUS_ACCEPTED)->latest();
    }
    public function scopeRejected($query)
    {
        return $query->where('confirmation_status', static::CONFIRMATION_STATUS_REJECTED)->latest();
    }
    public function scopePending($query)
    {
        return $query->where('confirmation_status', static::CONFIRMATION_STATUS_PENDING)->latest();
    }
    protected $appends = ['jalali_start_at', 'jalali_expired_at'];

    public function getJalaliStartAtAttribute()
    {
        $v = new Verta($this->start_at);
        $v->timezone('Asia/Tehran');
        return (string) $v;
    }
    public function getJalaliExpiredAtAttribute()
    {
        $v = new Verta($this->expired_at);
        $v->timezone('Asia/Tehran');
        return (string)$v;
    }
}

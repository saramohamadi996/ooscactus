<?php
namespace Milano\Payment\Models;
use Illuminate\Database\Eloquent\Model;
use Milano\User\Models\User;

class Settlement extends Model
{
    protected $guarded = [];

    const STATUS_PENDING = "pending";
    const STATUS_SETTLED = "settled";
    const STATUS_REJECTED = "rejected";
    const STATUS_CANCELLED = "cancelled";

    public static $statues = [
        self::STATUS_PENDING,
        self::STATUS_SETTLED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELLED
    ];

    protected $casts = [
        "to" => "json",
        "from" => "json"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusCssClass()
    {
        if ($this->status == Settlement::STATUS_PENDING) return "text-warning";
        if ($this->status == Settlement::STATUS_SETTLED) return "text-success";
        if ($this->status == Settlement::STATUS_REJECTED) return "text-error";
    }
}

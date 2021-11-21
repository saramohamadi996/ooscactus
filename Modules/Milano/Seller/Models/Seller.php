<?php
namespace Milano\Seller\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $guarded = [];
    protected $table = 'sellers';
    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses =
        [self::CONFIRMATION_STATUS_ACCEPTED,
        self::CONFIRMATION_STATUS_PENDING,
        self::CONFIRMATION_STATUS_REJECTED];
}

<?php
namespace Milano\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];
    protected $table = 'settings';

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED,
        self::CONFIRMATION_STATUS_PENDING,
        self::CONFIRMATION_STATUS_REJECTED];
}

<?php

namespace Milano\User\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyCode extends Model
{
    protected $table = 'verify_codes';

    protected $fillable = ['verify_code', 'mobile'];

    protected $casts = [
        'verify_code' => 'integer',
        'mobile' => 'string'
    ];

    public $timestamps = false;

    /**
     * Get the user associated with the verify code.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}

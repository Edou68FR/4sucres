<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    protected $guarded = [];

    const SCOPE_VERIFY_EMAIL = 1;
    const SCOPE_RESET_PASSWORD = 2;
    const SCOPE_GOOGLE_2FA = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

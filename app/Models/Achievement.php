<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievement')->withPivot('unlocked_at');
    }

    public function getImageUrlAttribute()
    {
        return url('/img/achievements/' . $this->image);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscordEmoji extends Model
{
    protected $increments = false;

    protected $guarded = [];

    protected $appends = ['link'];

    public function guild()
    {
        if (
            !$forceActual && ($this->type == Annonce::TYPE_FORMATION
                || $this->type == Annonce::TYPE_FORMATION_POSTE
                && $this->isPublieeSurActual())
        ) { }
    }

    public function getLinkAttribute()
    {
        $url = 'https://cdn.discordapp.com/emojis/' . $this->id;
        $url .= ($this->animated) ? '.gif' : '.png';

        return $url;
    }
}

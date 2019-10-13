<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class StaticPage extends Model
{
    protected $guarded = [];

    const TYPE_CONTENT = 1;
    const TYPE_REDIRECT = 2;
    const TYPE_REDIRECT_BLANK = 3;

    const POSITION_HIDDEN = 0;
    const POSITION_HEADER = 1;
    const POSITION_SIDEBAR = 2;
    const POSITION_FOOTER = 3;

    protected $appends = [
        'href',
    ];

    protected $hidden = [
        'created_at',
        'content',
        'updated_at',
        'id',
        'system',
        'updated_at',
    ];

    public function getParsedContentAttribute()
    {
        $converter = new CommonMarkConverter([
            'html_input'         => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level'  => 10,
            'renderer'           => [
                'block_separator' => "\n",
                'inner_separator' => "\n",
                'soft_break'      => "\n",
            ],
        ]);

        return $converter->convertToHtml($this->content);
    }

    public function getHrefAttribute()
    {
        return ($this->type == self::TYPE_REDIRECT || $this->type == self::TYPE_REDIRECT_BLANK) ? $this->content : null;
    }
}

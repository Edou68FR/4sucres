<?php

namespace App\Http\Controllers;

use App\Helpers\Shortlink;
use Vinkla\Hashids\Facades\Hashids;

class ShortlinkController extends Controller
{
    public function __invoke($hashId = null)
    {
        if (!$hashId || !count($hashId = Hashids::decode($hashId))) {
            return redirect()->route('home');
        }

        $targetId = substr($hashId[0], 1);
        switch (substr($hashId[0], 0, 1)) {
            case Shortlink::MODEL_POST:
                return redirect()->route('posts.show', $targetId);

            break;
        }

        return redirect()->route('home');
    }
}

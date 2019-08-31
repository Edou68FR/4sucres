<?php

namespace App\Http\Controllers;

class LegacyRedirectController extends Controller
{
    public function discussionCategoryIndex($category, $slug)
    {
        return redirect(route('discussions.categories.index', [$category, $slug]), 301);
    }

    public function discussionShow($id, $slug)
    {
        return redirect(route('discussions.show', [$id, $slug]), 301);
    }

    public function userShow($nameOrId)
    {
        return redirect(route('users.show', [$nameOrId]), 301);
    }

    public function postShow($id)
    {
        return redirect(route('posts.show', [$id]), 301);
    }
}

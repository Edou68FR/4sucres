<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Inertia\Inertia;

class StaticPageController extends Controller
{
    public function home()
    {
        $static_page = StaticPage::where('slug', 'home')->firstOrFail();

        $static_page->append('parsed_content');

        return Inertia::render('StaticPages/Home', compact('static_page'));
    }

    public function show($slug)
    {
        $static_page = StaticPage::where('slug', $slug)->firstOrFail();

        if ($static_page->type == StaticPage::TYPE_REDIRECT || $static_page->type == StaticPage::TYPE_REDIRECT_BLANK) {
            return redirect($static_page->content);
        }

        $static_page->append('parsed_content');

        return Inertia::render('StaticPages/Show', compact('static_page'));
    }
}

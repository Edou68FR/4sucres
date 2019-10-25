<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use ForceUTF8\Encoding;
use Spatie\Regex\Regex;
use App\Models\Category;
use App\Models\Discussion;
use Illuminate\Support\Str;
use App\Helpers\SucresHelper;

class SearchController extends Controller
{
    public function __invoke()
    {
        $data = [
            'q' => request()->input('q'),
            'scope' => request()->input('scope', 'discussions'),
        ];

        $categories = Category::viewables();

        SucresHelper::throttleOrFail(__METHOD__, 10, 1);

        switch ($data['scope']) {
            case 'discussions':
                $discussions = Discussion::query()
                    ->public()
                    ->whereIn('category_id', $categories->pluck('id'))
                    ->where('title', 'like', '%' . $data['q'] . '%')
                    ->orderBy('created_at', 'desc')
                    ->with('user')
                    ->paginate(15);

                $data['discussions'] = $discussions;
                break;
            case 'posts':
                $posts = Post::query()
                    ->notTrashed()
                    ->where('body', 'like', '%' . $data['q'] . '%')
                    ->orderBy('created_at', 'desc')
                    ->with('discussion')
                    ->with('user')
                    ->whereHas('discussion', function ($q) use ($categories) {
                        return $q->where('category_id', $categories->pluck('id'));
                    })
                    ->paginate(10);

                $posts
                    ->getCollection()
                    ->transform(function ($post) use ($data) {
                        $post->body = str_replace(["\n", "\r"], [''], $post->body);

                        $before = Str::before(strtolower($post->body), strtolower($data['q']));
                        $before = strrev((new \Delight\Str\Str(strrev($before)))->truncateSafely(20));
                        $after = Str::after(strtolower($post->body), strtolower($data['q']));
                        $after = (new \Delight\Str\Str($after))->truncateSafely(50);

                        $post->trimmed_body = $before . $data['q'] . $after;
                        $post->trimmed_body = Encoding::toUTF8($post->trimmed_body);

                        unset($post->body);
                        return $post;
                    });

                $data['posts'] = $posts;
                break;
            case 'users':
                $users = User::query()
                    ->where('name', 'like', '%' . $data['q'] . '%')
                    ->orWhere('display_name', 'like', '%' . $data['q'] . '%')
                    ->paginate(10);

                $data['users'] = $users;
                break;
        }

        return Inertia::render('Search/Query', $data);
    }
}

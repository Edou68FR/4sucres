<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Helpers\SucresParser;
use App\Models\Category;
use App\Models\Discussion;
use App\Models\Notification as NotificationModel;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DiscussionController extends Controller
{
    public function index($discussionId = null)
    {
        $data = [];

        if ($discussionId) {
            // Guess page from $discussionId
            $discussionPosition = array_search($discussionId, Discussion::ordered()->pluck('id')->toArray()) + 1;
            $guessedPage = ceil($discussionPosition / 20);
            request()->replace(
                array_merge(request()->all() + ['browse' => $guessedPage])
            );

            $data['discussion'] = function () use ($discussionId) {
                return $this->discussion($discussionId);
            };
        }

        $data['discussions'] = function () {
            return $this->discussions();
        };

        return Inertia::render('Discussions/Index', $data);
    }

    protected function discussions()
    {
        $sticky_discussions = collect();

        $discussions = Discussion::query()
            ->with('latestPost')
            ->with('latestPost.user')
            ->with('user');

        if (request()->get('browse', 1) == 1) {
            $sticky_discussions = (clone $discussions)
                ->sticky()
                ->get();
        }

        $discussions = $discussions
            ->ordered()
            ->paginate(20, ['*'], 'browse');

        if ($sticky_discussions->count()) {
            $discussions->setCollection(
                $sticky_discussions->merge($discussions)
            );
        }

        if (user()) {
            $user_has_seen = DB::table('has_read_discussions_users')
                ->select('discussion_id')
                ->distinct('discussion_id')
                ->where('user_id', user()->id)
                ->whereIn('discussion_id', $discussions->pluck('id'))
                ->pluck('discussion_id');

            $discussions->transform(function ($discussion) use ($user_has_seen) {
                $discussion->has_seen = $user_has_seen->has($discussion->id);
                return $discussion;
            });
        }

        return $discussions;
    }

    protected function discussion($discussionId)
    {
        $discussion = Discussion::query()
            ->with('user')
            ->findOrFail($discussionId);

        abort_if($discussion->deleted_at, 410);
        abort_if($discussion->private && (auth()->guest() || $discussion->members()->where('user_id', user()->id)->count() == 0), 403);

        // if (request()->page == 'last') {
        //     $post = $discussion
        //         ->hasMany(Post::class)
        //         ->orderBy('created_at', 'desc')
        //         ->first();

        //     return redirect(Discussion::link_to_post($post));
        // }

        $posts = $discussion
            ->posts()
            ->with('user')
            ->paginate(10);

        $posts->getCollection()->transform(function ($post) {
            return $post
                ->makeVisible(['created_at', 'updated_at', 'deleted_at'])
                ->append(['presented_body']);
        });

        if (user()) {
            // Invalidation des notifications qui font référence à cette discussion pour l'utilisateur connecté
            NotificationModel::query()
                ->where('read_at', null)
                ->where('notifiable_id', user()->id)
                ->whereIn('type', [
                    \App\Notifications\NewPrivateDiscussion::class,
                    \App\Notifications\RepliesInDiscussion::class,
                    \App\Notifications\ReplyInDiscussion::class,
                ])
                ->where('data->discussion_id', $discussion->id)
                ->update(['read_at' => now()]);

            // Invalidation des notifications qui font référence à ces posts pour l'utilisateur connecté
            NotificationModel::query()
                ->where('read_at', null)
                ->where('notifiable_id', user()->id)
                ->whereIn('type', [
                    \App\Notifications\MentionnedInPost::class,
                    \App\Notifications\QuotedInPost::class,
                ])
                ->whereIn('data->post_id', $posts->pluck('id'))
                ->update([
                    'read_at' => now(),
                ]);

            $discussion->has_read()->attach(user());
        }

        $discussion->posts = $posts;

        return $discussion;
    }

    public function create()
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        abort_if(user()->cannot('create discussions'), 403);

        return view('discussion.create', compact('categories'));
    }

    public function preview()
    {
        if (user()->cannot('create discussions')) {
            return abort(403);
        }

        request()->validate([
            'body' => 'required|min:3|max:10000',
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 15, 1);

        $post = new Post();
        $post->user = user();
        $post->body = request()->body;

        return response([
            'render' => (new SucresParser($post))->render(),
        ]);
    }

    public function store()
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        if (user()->cannot('create discussions')) {
            return abort(403);
        }

        $categories = Category::postables()->pluck('id');

        request()->validate([
            'title'    => ['required', 'min:3', 'max:255'],
            'body'     => ['required', 'min:3', 'max:10000'],
            'category' => ['required', 'exists:categories,id', Rule::in($categories)],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 5, 10);

        $discussion = Discussion::create([
            'title'       => request()->title,
            'user_id'     => user()->id,
            'category_id' => request()->category,
        ]);

        $post = $discussion->posts()->create([
            'body'    => request()->body,
            'user_id' => user()->id,
        ]);

        if (user()->getSetting('notifications.subscribe_on_create', true)) {
            $discussion->subscribed()->syncWithoutDetaching(user()->id);
        }

        return redirect($post->link);
    }

    public function subscriptions()
    {
        $categories = Category::viewables();

        $discussions = Discussion::query()
            ->whereIn('category_id', $categories->pluck('id'))
            ->with('category')
            ->with('latestPost')
            ->with('latestPost.user')
            ->with('user')
            ->whereHas('subscribed', function ($q) {
                return $q->where('user_id', user()->id);
            });

        if (request()->input('page', 1) == 1) {
            $sticky_discussions = clone $discussions;
            $sticky_discussions = $sticky_discussions->sticky()->get();
        } else {
            $sticky_discussions = collect([]);
        }

        $discussions = $discussions->ordered()->paginate(20);

        if (user()) {
            $user_has_seen = DB::table('has_read_discussions_users')
                ->select('discussion_id')
                ->where('user_id', user()->id)
                ->whereIn('discussion_id', array_merge($sticky_discussions->pluck('id')->toArray(), $discussions->pluck('id')->toArray()))
                ->pluck('discussion_id')
                ->toArray();
        } else {
            $user_has_seen = [];
        }

        return view('welcome', compact('categories', 'sticky_discussions', 'discussions', 'user_has_seen'));
    }

    public function update(Discussion $discussion, $slug)
    {
        if (($discussion->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        $categories = Category::postables();

        if (!in_array($discussion->category->id, $categories->pluck('id')->toArray())) {
            return abort(403);
        }

        request()->validate([
            'title'    => 'required|min:4|max:255',
            'category' => ['required', 'exists:categories,id', Rule::in($categories->pluck('id'))],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 3, 5);

        $discussion->title = request()->title;

        // Do not update category if the post is in #shitpost
        if ($discussion->category_id !== \App\Models\Category::SHITPOST_CATEGORY_ID || user()->can('bypass discussions guard')) {
            $discussion->category_id = request()->category;
        }

        if (user()->can('bypass discussions guard')) {
            $discussion->sticky = request()->sticky ?? false;
            $discussion->locked = request()->locked ?? false;

            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'    => 'warning',
                    'method'   => __METHOD__,
                    'elevated' => true,
                ])
                ->log('DiscussionUpdated');
        }

        $discussion->save();

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }

    public function subscribe(Discussion $discussion, $slug)
    {
        if ($discussion->private) {
            return abort(403);
        }

        if (!in_array($discussion->category->id, Category::viewables()->pluck('id')->toArray())) {
            return abort(403);
        }

        $discussion->subscribed()->syncWithoutDetaching(user()->id);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }

    public function unsubscribe(Discussion $discussion, $slug)
    {
        if ($discussion->private) {
            return abort(403);
        }

        if (!in_array($discussion->category->id, Category::viewables()->pluck('id')->toArray())) {
            return abort(403);
        }

        $discussion->subscribed()->detach(user()->id);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }
}

@php
    if (!isset($current)) {
        $current = (new stdClass);
        $current->discussion_id = null;
    }
@endphp

<blockquote class="rounded shadow bg-surface text-on-surface">
    <div class="p-4">
        <div>
            <a href="{{ route('users.show', $post->user->name) }}" class="font-semibold">{{ $post->user->display_name }}</a>
            @if ($post->user->display_name != $post->user->name) {{ '@' . $post->user->name }} @endif
        </div>
    </div>
    <hr class="border-body-border">
    <div class="p-4 user-content">
        @if ($post->deleted_at)
            <i class="fas fa-times"></i> Message supprimé</div>
        @else
            {!! $post->presented_light_body !!}
        @endif
    </div>
</blockquote>
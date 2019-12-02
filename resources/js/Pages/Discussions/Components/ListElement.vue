<template>
  <div class="px-4 py-2 text-on-surface hover:bg-surface">
    <div class="flex items-center">
      <div class="flex-none mr-4">
        <div class="px-2 py-1 text-sm text-center rounded bg-discussion-icon text-on-discussion-icon"
          :class="{
            'bg-discussion-icon-hot' : (discussion.replies >= 10 && !discussion.sticky),
            'bg-discussion-icon-locked' : (discussion.locked),
            'bg-discussion-icon-pinned' : (discussion.sticky),
          }">
          <i
            class="fas fa-folder"
            style="width: 1em;"
            :class="{
                'fa-lock' : (discussion.locked),
                'fa-thumbtack' : (discussion.sticky),
                'fa-shield-alt' : (discussion.private),
              }"
          ></i>
        </div>
      </div>
      <div class="flex flex-wrap items-center m-w-0 md:flex-1 md:flex-no-wrap">
        <div class="m-w-0">
          <div class="truncate">
            <inertia-link
              :href="route('discussions.show', [discussion.id, discussion.slug])"
              class="font-bold accent"
              v-html="discussion.title"
            ></inertia-link>
          </div>
          <div class="text-sm truncate">
            le {{ moment(discussion.created_at).calendar() }}
            par
            <inertia-link
              :href="route('users.show', discussion.user.name)"
            >{{ discussion.user.display_name }}</inertia-link>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap items-center flex-none w-12 ml-auto text-sm text-center md:w-32 lg:w-40 md:text-right m-w-0">
        <div class="w-full truncate md:flex-1 md:ml-0 md:mr-4"
          :class="{'font-bold text-red-600': ($page.auth.user && !discussion.has_seen)}">
          <inertia-link
            :href="route('users.show', discussion.latest_post.user.name)"
            class="hidden md:inline"
          >{{ discussion.latest_post.user.display_name }}</inertia-link>
          <br class="hidden md:block" />
          <inertia-link :href="route('posts.show', discussion.latest_post.id)">
            <span class="hidden md:inline">il y a</span>
            {{ moment(discussion.latest_post.created_at).fromNow().replace('il y a ', '') }}
          </inertia-link>
        </div>
        <div class="mx-auto">
          <img
            :src="discussion.latest_post.user.avatar_url"
            :alt="'Avatar de ' + discussion.latest_post.user.display_name"
            class="rounded shadow wh-10"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    props: ['discussion']
}
</script>
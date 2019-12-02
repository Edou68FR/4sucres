<template>
  <div class="card hoverable px-4 py-2">
    <div class="flex items-center">
      <div class="mr-4 flex-none">
        <div class="badge bg-gold-600"
          :class="{
            'bg-red-600' : (discussion.replies >= 10),
            'bg-gray-600' : (discussion.locked),
            'bg-green-600' : (discussion.sticky),
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
      <div class="m-w-0 md:flex-1 flex flex-wrap md:flex-no-wrap items-center">
        <div class="m-w-0">
          <div class="truncate">
            <inertia-link
              :href="route('discussions.show', [discussion.id, discussion.slug])"
              class="font-bold accent"
              v-html="discussion.title"
            ></inertia-link>
          </div>
          <div class="truncate text-sm">
            le {{ moment(discussion.created_at).calendar() }}
            par
            <inertia-link
              :href="route('users.show', discussion.user.name)"
            >{{ discussion.user.display_name }}</inertia-link>
          </div>
        </div>
      </div>
      <div class="w-12 md:w-32 lg:w-40 ml-auto flex-none flex flex-wrap items-center text-sm text-center md:text-right m-w-0">
        <div class="w-full md:flex-1 truncate md:ml-0 md:mr-4"
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
            class="rounded wh-10 shadow"
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
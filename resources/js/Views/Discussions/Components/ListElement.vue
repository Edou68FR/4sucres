<template>
  <div class="px-6 py-4 hover:bg-surface-hover">
    <div class="flex items-center">
      <div class="relative flex-none mx-auto mr-6">
        <user-avatar :user="discussion.latest_post.user" />
        <div class="absolute px-2 py-1 text-center rounded bg-discussion-icon text-on-discussion-icon"
            style="font-size: .7rem; bottom: -.3rem; right: -.5rem;"
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
      <div class="flex-grow m-w-0">
        <div class="m-w-0">
          <div class="truncate">
            <inertia-link
              :href="route('discussions.show', [discussion.id, discussion.slug])"
              class="font-semibold">
              {{ discussion.title }}
            </inertia-link>
          </div>
          <!-- <inertia-link :href="route('users.show', discussion.user.name)">{{ discussion.user.display_name }}</inertia-link> -->
          <div class="text-sm">
            <inertia-link :href="route('users.show', discussion.user.name)">{{ discussion.user.display_name }}</inertia-link> {{ moment(discussion.user.created_at).fromNow() }}
          </div>
        </div>
      </div>
      <div class="flex-none">
        <inertia-link :href="route('posts.show', discussion.latest_post.id)">
          {{ moment(discussion.latest_post.created_at).fromNow().replace('il y a ', '') }}
        </inertia-link>
        <i
          class="ml-2 text-sm text-brand fas fa-circle"
          :class="{'hidden': ($page.auth.user && !discussion.has_seen)}" />
      </div>
    </div>
  </div>
</template>

<script>
import UserAvatar from '@/Components/UserAvatar';
import UserName from '@/Components/UserName';

export default {
    components: { UserAvatar, UserName },
    props: ['discussion']
}
</script>
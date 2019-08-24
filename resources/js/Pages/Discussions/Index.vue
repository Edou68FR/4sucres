<template>
  <layout>
    <div class="flex items-center mb-6">
      <div class="mr-auto">
        <template v-if="discussions.current_page > 1">
          <inertia-link :href="discussions.first_page_url"><i class="fas fa-angle-double-left"></i></inertia-link>
          <inertia-link :href="discussions.prev_page_url"><i class="fas fa-angle-left"></i></inertia-link>
        </template>
      </div>
      <div class="text-muted text-xs">
        {{ discussions.current_page }}/{{ discussions.last_page }}
      </div>
      <div class="ml-auto">
        <template v-if="discussions.current_page < discussions.last_page">
          <inertia-link :href="discussions.next_page_url"><i class="fas fa-angle-right"></i></inertia-link>
          <inertia-link :href="discussions.last_page_url"><i class="fas fa-angle-double-right"></i></inertia-link>
        </template>
      </div>
    </div>

      <div class="card mb-2 p-2" v-for="discussion in discussions.data" :key="discussion.id">
        <div class="flex items-center d-flex">
          <div class="overflow-ellipsis m-w-0">
            <div class="truncate">
              <a :href="route('discussions.show', [discussion.id, discussion.slug])" :class="{
                'font-bold': $page.auth.user && !user_has_read.includes(discussion.id)
              }">{{ discussion.title }}</a>
            </div>
            <div class="text-xs">
              par
              <a :href="route('user.show', discussion.user.name)">{{ discussion.user.display_name }}</a>, {{ moment(discussion.created_at).calendar() }}
            </div>
          </div>
          <div class="ml-auto mr-4 text-right text-xs">
              {{ discussion.replies }}
              <i class="fas fw-fw ml-1"
                :class="{'text-red-500' : (discussions.replies >= 10), 'fa-comments' : (discussion.replies > 1), 'fa-comment' : (discussion.replies <= 1)}"></i><br>
              0 <i class="fas fw-fw ml-1 fa-eye"></i>
          </div>
          <div class="w-48 flex items-center text-xs">
              <div class="mr-4">
                <img :src="discussion.latest_post.user.avatar_link" :alt="'Avatar de ' + discussion.latest_post.user.display_name" class="rounded h-8 v-8">
              </div>
              <div>
                <a :href="route('user.show', discussion.latest_post.user.name)">{{ discussion.latest_post.user.display_name }}</a><br>
                <a :href="route('posts.show', discussion.latest_post.id)">{{ moment(discussion.latest_post.created_at).fromNow() }}</a>
              </div>
          </div>
        </div>
      </div>

  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: {
    Layout
  },
  props:[ "categories", "sticky_discussions", "discussions", "user_has_read"],
  mounted: function() {
    console.log(this.discussions);
  }
};
</script>
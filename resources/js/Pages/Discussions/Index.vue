<template>
  <layout>
    <div class="flex items-center mb-6">
      <div class="mr-auto">
        <template v-if="discussions.current_page > 1">
          <inertia-link :href="discussions.first_page_url" class="inactive"><i class="fas fa-angle-double-left"></i></inertia-link>
          <inertia-link :href="discussions.prev_page_url" class="inactive"><i class="fas fa-angle-left"></i></inertia-link>
        </template>
      </div>
      <div class="text-xs">
        {{ discussions.current_page }}/{{ discussions.last_page }}
      </div>
      <div class="ml-auto">
        <template v-if="discussions.current_page < discussions.last_page">
          <inertia-link :href="discussions.next_page_url" class="inactive"><i class="fas fa-angle-right"></i></inertia-link>
          <inertia-link :href="discussions.last_page_url" class="inactive"><i class="fas fa-angle-double-right"></i></inertia-link>
        </template>
      </div>
    </div>

      <div class="card mb-2 py-2 px-4" v-for="discussion in discussions.data" :key="discussion.id">
        <div class="flex items-center">
          <div class="mr-4 text-muted">
            <i class="fas fa-folder"
              :class="{
                'text-red-600' : (discussion.replies >= 10),
                'fa-lock text-yellow-600' : (discussion.locked),
                'fa-thumbtack text-green-600' : (discussion.sticky),
                'fa-shield-alt' : (discussion.private),
              }"></i>
          </div>
          <div class="m-w-0">
            <div class="truncate">
              <a :href="route('discussions.show', [discussion.id, discussion.slug])" class="font-bold" v-html="discussion.title"></a>
            </div>
            <div class="text-xs">
              par
              <a :href="route('user.show', discussion.user.name)" class="inactive">{{ discussion.user.display_name }}</a>, {{ moment(discussion.created_at).calendar() }}
            </div>
          </div>
          <div class="ml-auto mr-4 text-right text-xs">
              <div v-if="$page.auth.user && !user_has_read.includes(discussion.id)" class="font-bold text-red-600">
                {{ discussion.replies }} réponses
              </div>
              <div v-else>
                {{ discussion.replies }} réponses
              </div>

              <!-- <i class="fas fw-fw ml-1"
                :class="{'fa-comments' : (discussion.replies > 1), 'fa-comment' : (discussion.replies <= 1)}"></i><br> -->
              <!-- 0 <i class="fas fw-fw ml-1 fa-eye"></i> -->
              0 vues
          </div>
          <div class="w-40 flex items-center text-xs m-w-0">
              <div class="mr-4">
                <img :src="discussion.latest_post.user.avatar_link" :alt="'Avatar de ' + discussion.latest_post.user.display_name" class="rounded h-8 v-8">
              </div>
              <div class="truncate">
                <a :href="route('user.show', discussion.latest_post.user.name)" class="inactive">{{ discussion.latest_post.user.display_name }}</a><br>
                <a :href="route('posts.show', discussion.latest_post.id)" class="inactive">{{ moment(discussion.latest_post.created_at).fromNow() }}</a>
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
  props:[ "categories", "discussions", "user_has_read"],
};
</script>
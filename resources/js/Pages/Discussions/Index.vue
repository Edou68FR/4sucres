<template>
  <layout>
    <div class="flex items-center mb-6">
      <div class="mr-auto">
        <template v-if="discussions.current_page > 1">
          <inertia-link preserve-scroll :href="discussions.first_page_url" class="inactive"><i class="fas fa-angle-double-left"></i></inertia-link>
          <inertia-link preserve-scroll :href="discussions.prev_page_url" class="inactive"><i class="fas fa-angle-left"></i></inertia-link>
        </template>
      </div>
      <div class="text-xs">
        {{ discussions.current_page }}/{{ discussions.last_page }}
      </div>
      <div class="ml-auto">
        <template v-if="discussions.current_page < discussions.last_page">
          <inertia-link preserve-scroll :href="discussions.next_page_url" class="inactive"><i class="fas fa-angle-right"></i></inertia-link>
          <inertia-link preserve-scroll :href="discussions.last_page_url" class="inactive"><i class="fas fa-angle-double-right"></i></inertia-link>
        </template>
      </div>
    </div>
    <div class="card hoverable mb-2 py-2 px-4" v-for="discussion in discussions.data" :key="discussion.id" v-on:click="visit($inertia, route('discussions.show', [discussion.id, discussion.slug]), $event)">
      <div class="flex items-center">
        <div class="mr-4 flex-none text-muted">
            <i class="fas fa-folder"
              :class="{
                'text-red-600' : (discussion.replies >= 10),
                'fa-lock text-yellow-600' : (discussion.locked),
                'fa-thumbtack text-green-600' : (discussion.sticky),
                'fa-shield-alt' : (discussion.private),
              }"></i>
        </div>
        <div class="m-w-0 md:flex-1 flex flex-wrap md:flex-no-wrap items-center">
          <div class="m-w-0">
            <div class="truncate">
              <inertia-link :href="route('discussions.show', [discussion.id, discussion.slug])" class="font-bold" v-html="discussion.title"></inertia-link>
            </div>
            <div class="text-xs">
              par
              <inertia-link :href="route('user.show', discussion.user.name)" class="inactive">{{ discussion.user.display_name }}</inertia-link>, {{ moment(discussion.created_at).calendar() }}
            </div>
          </div>
          <div class="ml-auto flex-none w-full md:w-auto md:mr-4 md:text-right text-xs">
              <span v-if="$page.auth.user && !user_has_read.includes(discussion.id)" class="font-bold text-red-600 md:block">
                {{ discussion.replies }} réponses<span class="md:hidden">,</span>
              </span>
              <span v-else class="md:block">
                {{ discussion.replies }} réponses<span class="md:hidden">,</span>
              </span>
              <!-- <i class="fas fw-fw ml-1"
                :class="{'fa-comments' : (discussion.replies > 1), 'fa-comment' : (discussion.replies <= 1)}"></i><br> -->
              <!-- 0 <i class="fas fw-fw ml-1 fa-eye"></i> -->
              0 vues
          </div>
        </div>
        <div class="w-12 md:w-40 ml-auto flex-none flex flex-wrap items-center text-xs text-center md:text-left m-w-0">
          <div class="mx-auto md:ml-0 md:mr-4">
            <img :src="discussion.latest_post.user.avatar_link" :alt="'Avatar de ' + discussion.latest_post.user.display_name" class="rounded h-8 v-8">
          </div>
          <div class="w-full md:flex-1 truncate">
            <inertia-link :href="route('user.show', discussion.latest_post.user.name)" class="hidden md:inline inactive">{{ discussion.latest_post.user.display_name }}</inertia-link>
            <br class="hidden md:block">
            <inertia-link :href="route('posts.show', discussion.latest_post.id)" class="inactive">
              <span class="hidden md:inline">il y a</span>
              {{ moment(discussion.latest_post.created_at).fromNow().replace('il y a ', '') }}
            </inertia-link>
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
  methods : {
    visit($inertia, url, $event) {
      if (!$event.srcElement.matches('a')) $inertia.visit(url);
    }
  }
};
</script>
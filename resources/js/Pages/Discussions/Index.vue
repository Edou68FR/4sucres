<template>
  <layout>
    <div class="cards my-6">
      <div class="card hoverable py-2 px-4" v-for="discussion in discussions.data" :key="discussion.id" v-on:click="visit($inertia, route('discussions.show', [discussion.id, discussion.slug]), $event)">
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
                <inertia-link :href="route('discussions.show', [discussion.id, discussion.slug])" class="font-bold accent" v-html="discussion.title"></inertia-link>
              </div>
              <div class="text-xs">
                par
                <inertia-link :href="route('user.show', discussion.user.name)">{{ discussion.user.display_name }}</inertia-link>, {{ moment(discussion.created_at).calendar() }}
              </div>
            </div>
            <div class="ml-auto flex-none w-full md:w-auto md:mr-4 md:text-right text-xs">
                <span v-if="$page.auth.user && !user_has_read.includes(discussion.id)" class="font-bold text-red-600 md:block">
                  {{ discussion.replies }} réponses<span class="md:hidden">,</span>
                </span>
                <span v-else class="md:block">
                  {{ discussion.replies }} réponses<span class="md:hidden">,</span>
                </span>
                0 vues
            </div>
          </div>
          <div class="w-12 md:w-40 ml-auto flex-none flex flex-wrap items-center text-xs text-center md:text-left m-w-0">
            <div class="mx-auto md:ml-0 md:mr-4">
              <img :src="discussion.latest_post.user.avatar_link" :alt="'Avatar de ' + discussion.latest_post.user.display_name" class="rounded wh-8">
            </div>
            <div class="w-full md:flex-1 truncate">
              <inertia-link :href="route('user.show', discussion.latest_post.user.name)" class="hidden md:inline">{{ discussion.latest_post.user.display_name }}</inertia-link>
              <br class="hidden md:block">
              <inertia-link :href="route('posts.show', discussion.latest_post.id)">
                <span class="hidden md:inline">il y a</span>
                {{ moment(discussion.latest_post.created_at).fromNow().replace('il y a ', '') }}
              </inertia-link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card p-4">
      <paginator :paginator="_.omit(discussions, 'data')"></paginator>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import Paginator from '@/Shared/Components/Paginator';

export default {
  components: { Layout, Paginator },
  props:[ "categories", "discussions", "user_has_read" ],
  methods : {
    visit($inertia, url, $event) {
      if (!$event.srcElement.matches('a')) $inertia.visit(url);
    }
  }
};
</script>
<template>
  <layout>
    <div class="header">
      <div class="container mx-auto">
        <div class="flex items-center justify-between">
          <div class="px-2">
            <div class="page-title">
              <template v-if="category">
                <inertia-link :href="route('discussions.index')">Discussions</inertia-link>
                <span class="text-muted mx-2">/</span>
                <span>{{ category.name }}</span>
              </template>
              <span v-else>Discussions</span>
            </div>
          </div>
          <div class="px-2">
            <inertia-link
              class="mx-1 btn btn-lg btn-primary"
              v-if="$page.auth.user && $page.auth.user.permissions.includes('create discussions')"
              :href="route('discussions.create')"
            >
              <i class="inline-block sm:hidden fas fa-plus"></i>
              <span class="hidden sm:inline">Nouvelle discussion</span>
            </inertia-link>
            <button class="mx-1 btn btn-lg btn-secondary" v-on:click="reload">
              <i class="fas fa-sync"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="container mx-auto">
      <div class="cards mb-6 -mx-6 sm:mx-auto">
        <div
          class="card hoverable px-4 py-3"
          v-for="discussion in discussions.data"
          :key="discussion.id"
          v-on:click="visit(route('discussions.show', [discussion.id, discussion.slug]), $event)"
        >
          <div class="flex items-center">
            <div class="mr-4 flex-none text-base-folder">
              <i
                class="fas fa-folder"
                :class="{
                    'text-red-600' : (discussion.replies >= 10),
                    'fa-lock text-gray-600' : (discussion.locked),
                    'fa-thumbtack text-green-600' : (discussion.sticky),
                    'fa-shield-alt' : (discussion.private),
                  }"
              ></i>
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
                <div class="text-sm">
                  par
                  <inertia-link
                    :href="route('users.show', discussion.user.name)"
                  >{{ discussion.user.display_name }}</inertia-link>
                  ,
                  {{ moment(discussion.created_at).calendar() }},
                  <inertia-link
                    :href="route('discussions.categories.index', [discussion.category.id, discussion.category.slug])"
                  >{{ discussion.category.name }}</inertia-link>
                </div>
              </div>
              <div class="ml-auto flex-none w-full md:w-auto md:mr-4 md:text-right text-sm">
                <span
                  v-if="$page.auth.user && !user_has_read.includes(discussion.id)"
                  class="font-bold text-red-600 md:block"
                >
                  {{ discussion.replies }} réponses
                  <span class="md:hidden">,</span>
                </span>
                <span v-else class="md:block">
                  {{ discussion.replies }} réponses
                  <span class="md:hidden">,</span>
                </span>
              </div>
            </div>
            <div class="w-12 md:w-40 lg:w-48 ml-auto flex-none flex flex-wrap items-center text-sm text-center md:text-left m-w-0">
              <div class="mx-auto md:ml-0 md:mr-4">
                <img
                  :src="discussion.latest_post.user.avatar_url"
                  :alt="'Avatar de ' + discussion.latest_post.user.display_name"
                  class="rounded wh-8"
                />
              </div>
              <div class="w-full md:flex-1 truncate">
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
            </div>
          </div>
        </div>
      </div>

      <SimplePaginator class="text-center" :paginator="_.omit(discussions, 'data')"></SimplePaginator>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import SimplePaginator from "@/Shared/Components/SimplePaginator";

export default {
  components: { Layout, SimplePaginator },
  props: ["categories", "category", "discussions", "user_has_read"],
  methods: {
    visit(url, $event) {
      if (!$event.srcElement.matches("a")) this.$inertia.visit(url);
    },
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    }
  }
};
</script>
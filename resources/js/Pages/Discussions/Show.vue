<template>
  <layout>
    <div class="container mx-auto mb-6">
      <div class="cards">
        <div class="card p-6">
          <div class="flex items-center justify-between">
            <div class="flex-grow m-w-0">
              <div class="page-title" v-html="discussion.title"></div>
              <inertia-link :href="route('discussions.categories.index', [discussion.category.id, discussion.category.slug])">{{ discussion.category.name }}</inertia-link>
            </div>
            <div class="flex-none">
              <template v-if="$page.auth.user">
                <!-- <inertia-link class="mx-1 btn btn-lg btn-primary" href="#">
                  <i class="inline-block sm:hidden fas fa-plus"></i>
                  <span class="hidden sm:inline">Répondre</span>
                </inertia-link> -->
                <inertia-link
                  class="mx-1 btn btn-lg btn-secondary"
                  :href="route('discussions.unsubscribe', [discussion.id, discussion.slug])"
                >
                  <i class="far fa-star"></i>
                </inertia-link>
              </template>
              <button class="mx-1 btn btn-lg btn-secondary" v-on:click="reload">
                <i class="fas fa-sync"></i>
              </button>
            </div>
          </div>
          <simple-paginator class="mt-6" :paginator="_.omit(posts, 'data')"></simple-paginator>
        </div>
        <div v-for="post in posts.data" :key="post.id" class="card flex-1">
          <div class="flex items-center px-6 py-4">
            <inertia-link :href="route('users.show', post.user.name)" class="hidden sm:block wh-10 mr-4">
              <img
                :src="post.user.avatar_url"
                :alt="'Avatar de ' + post.user.display_name"
                class="rounded wh-10 shadow" />
            </inertia-link>
            <div>
              <inertia-link :href="route('users.show', post.user.name)">
                <strong>{{ post.user.display_name }}</strong>
              </inertia-link>
              <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
              <br>
              <inertia-link :href="post.shortlink_url" class="text-sm">
                {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
                <span
                  v-if="post.created_at != post.updated_at"
                >(modifié, {{ moment(post.updated_at).calendar() }})</span>
              </inertia-link>
            </div>
            <div class="ml-auto">
              <inertia-link href="#" class="btn btn-sm btn-tertiary">
                <i class="fas fa-quote-right"></i>
              </inertia-link>
              <template v-if="$page.auth.user">
                <inertia-link
                  v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                  :href="route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])"
                  class="btn btn-sm btn-tertiary">
                  <i class="fas fa-edit"></i>
                </inertia-link>
                <inertia-link
                  v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                  :href="route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])"
                  class="btn btn-sm btn-tertiary">
                  <i class="fas fa-trash"></i>
                </inertia-link>
              </template>
            </div>
          </div>

          <hr>

          <div v-html="post.presented_body" class="post p-6" v-if="!post.deleted_at"></div>
          <div class="p-6 text-red-600" v-if="post.deleted_at">
            <i class="fas fa-times mr-1"></i> Ce message a été supprimé
          </div>
        </div>
        <div class="card p-6">
          <simple-paginator class="text-center" :paginator="_.omit(posts, 'data')"></simple-paginator>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import Paginator from "@/Shared/Components/Paginator";
import SimplePaginator from "@/Shared/Components/SimplePaginator";

export default {
  components: { Layout, Paginator, SimplePaginator },
  props: ["discussion", "posts"],
  methods: {
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    }
  }
};
</script>
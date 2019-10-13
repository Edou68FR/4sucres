<template>
  <layout>
    <div class="flex justify-center flex-wrap sm:flex-no-wrap mb-6">
      <div class="flex-grow m-w-0 page-title mb-3">
        <inertia-link :href="route('discussions.index')">
          Discussions
        </inertia-link>
        <span class="text-muted mx-2">/</span>
        <inertia-link :href="route('discussions.categories.index', [discussion.category.id, discussion.category.slug])">
          {{ discussion.category.name }}
        </inertia-link>
        <span class="text-muted mx-2">/</span>
        <span v-html="discussion.title"></span>
      </div>
      <div class="flex-none">
        <template v-if="$page.auth.user">
          <inertia-link class="mx-1 btn btn-primary" href="#">
            <i class="inline-block sm:hidden fas fa-plus"></i><span class="hidden sm:inline">Répondre</span>
          </inertia-link>
          <inertia-link class="mx-1 btn btn-secondary" :href="route('discussions.unsubscribe', [discussion.id, discussion.slug])">
            <i class="far fa-star"></i>
          </inertia-link>
        </template>
        <button class="mx-1 btn btn-secondary" v-on:click="reload">
          <i class="fas fa-sync"></i>
        </button>
      </div>
    </div>

    <hr>

    <simple-paginator class="text-center my-6" :paginator="_.omit(posts, 'data')"></simple-paginator>

    <div class="cards my-6 -mx-6 sm:mx-auto">
      <div class="card" v-for="post in posts.data" :key="post.id">
        <div class="flex p-4">
          <div class="hidden sm:block flex-none mr-4">
            <inertia-link :href="route('users.show', post.user.name)">
              <img :src="post.user.avatar_url" :alt="'Avatar de ' + post.user.display_name" class="rounded wh-10 mt-1">
            </inertia-link>
          </div>
          <div class="flex-1 m-w-0">
            <div class="flex mb-4">
                <div>
                  <inertia-link :href="route('users.show', post.user.name)">
                    <img :src="post.user.avatar_url" :alt="'Avatar de ' + post.user.display_name" class="rounded inline sm:hidden wh-6 mt-1">
                  </inertia-link>

                  <i v-if="post.user.id === discussion.user.id" class="fas fa-crown text-muted" :title="post.user.display_name + ' est l\'auteur de ce topic.'"></i>
                  <i v-if="post.user.is_birthday" class="fas fa-birthday-cake text-muted" :title="'C\'est l\'anniversaire de ' + post.user.display_name + ', aujourd\'hui.'"></i>
                  <inertia-link :href="route('users.show', post.user.name)">
                    <strong>{{ post.user.display_name }}</strong>
                  </inertia-link>
                  <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
                  <inertia-link :href="route('posts.show', post.id)" class="text-xs">
                    {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
                    <span v-if='post.created_at != post.updated_at'>(modifié, {{ moment(post.updated_at).calendar() }})</span>
                  </inertia-link>
              </div>
              <div class="ml-auto text-xs">
                <inertia-link href="#" class="mr-1"><i class="fas fa-link"></i></inertia-link>
                <inertia-link href="#" class="mr-1"><i class="fas fa-quote-right"></i></inertia-link>
                <template v-if="$page.auth.user">
                  <inertia-link v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')" :href="route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])" class="mr-1"><i class="fas fa-edit"></i></inertia-link>
                  <inertia-link v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')" :href="route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])" class="mr-1"><i class="fas fa-trash"></i></inertia-link>
                </template>
              </div>
            </div>
            <div v-html="post.presented_body" class="post"></div>
          </div>
          </div>
        </div>
      </div>
    </div>

    <simple-paginator class="text-center" :paginator="_.omit(posts, 'data')"></simple-paginator>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import Paginator from '@/Shared/Components/Paginator';
import SimplePaginator from '@/Shared/Components/SimplePaginator';

export default {
  components: { Layout, Paginator, SimplePaginator },
  props: [ "discussion", "posts" ],
  methods: {
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    }
  }
};
</script>
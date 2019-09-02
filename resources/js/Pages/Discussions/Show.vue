<template>
  <layout>
    <div class="flex items-center mb-6">
      <div class="card border py-1 px-2">
          <inertia-link :href="route('discussions.index')">
            Discussions
          </inertia-link>
          <span class="text-xs text-muted mx-1">/</span>
          <inertia-link :href="route('discussions.categories.index', [discussion.category.id, discussion.category.slug])">
            {{ discussion.category.name }}
          </inertia-link>
          <span class="text-xs text-muted mx-1">/</span>
          <span>{{ discussion.title }}</span>
      </div>

      <div class="ml-auto">
        <template v-if="$page.auth.user">
          <button class="mx-1 btn btn-secondary" v-on:click="reload">
            <i class="far fa-star"></i>
          </button>
        </template>
        <button class="mx-1 btn btn-secondary" v-on:click="reload">
          <i class="fas fa-sync"></i>
        </button>
      </div>
    </div>

    <simple-paginator class="text-center my-6" :paginator="_.omit(posts, 'data')"></simple-paginator>

    <div class="cards my-6">
      <div class="card" v-for="post in posts.data" :key="post.id">
        <div class="flex p-4">
          <div class="flex-none mr-4">
            <inertia-link :href="route('users.show', post.user.name)">
              <img :src="post.user.avatar_url" :alt="'Avatar de ' + post.user.display_name" class="rounded wh-10 mt-1">
            </inertia-link>
          </div>
          <div class="flex-1">
            <div class="flex mb-4">
                <div>
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
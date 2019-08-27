<template>
  <layout>
    <div class="card p-4">
      <paginator :paginator="_.omit(posts, 'data')"></paginator>
    </div>

    <div class="cards my-6">
      <div class="card p-4" v-for="post in posts.data" :key="post.id">
        <div class="flex items-center">
          <div class="flex-none mr-4">
            <inertia-link :href="route('user.show', post.user.name)">
              <img :src="post.user.avatar_link" :alt="'Avatar de ' + post.user.display_name" class="rounded wh-12">
            </inertia-link>
          </div>
          <div>
              <i v-if="post.user.id === discussion.user.id" class="fas fa-crown text-muted" :title="post.user.display_name + ' est l\'auteur de ce topic.'"></i>
              <i v-if="post.user.is_birthday" class="fas fa-birthday-cake text-muted" :title="'C\'est l\'anniversaire de ' + post.user.display_name + ', aujourd\'hui.'"></i>
              <inertia-link :href="route('user.show', post.user.name)">
                <strong>{{ post.user.display_name }}</strong>
              </inertia-link>
              <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
              <br>
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
        <hr>
        <div v-html="post.presented_body" class="post"></div>
      </div>
    </div>

    <div class="card p-4">
      <paginator :paginator="_.omit(posts, 'data')"></paginator>
    </div>

  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import Paginator from '@/Shared/Components/Paginator';

export default {
  components: { Layout, Paginator },
  props:[ "discussion", "posts" ],
};
</script>
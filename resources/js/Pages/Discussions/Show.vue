<template>
  <layout>
    <div class="flex items-center mb-6">
      <div class="mr-auto">
        <template v-if="posts.current_page > 1">
          <inertia-link preserve-scroll :href="posts.first_page_url" class="inactive"><i class="fas fa-angle-double-left"></i></inertia-link>
          <inertia-link preserve-scroll :href="posts.prev_page_url" class="inactive"><i class="fas fa-angle-left"></i></inertia-link>
        </template>
      </div>
      <div class="text-xs">
        {{ posts.current_page }}/{{ posts.last_page }}
      </div>
      <div class="ml-auto">
        <template v-if="posts.current_page < posts.last_page">
          <inertia-link preserve-scroll :href="posts.next_page_url" class="inactive"><i class="fas fa-angle-right"></i></inertia-link>
          <inertia-link preserve-scroll :href="posts.last_page_url" class="inactive"><i class="fas fa-angle-double-right"></i></inertia-link>
        </template>
      </div>
    </div>
    <div class="card mb-2 p-4" v-for="post in posts.data" :key="post.id">
      <div class="flex">
        <div class="mr-4 flex-none">
          <inertia-link :href="route('user.show', post.user.name)">
            <img :src="post.user.avatar_link" :alt="'Avatar de ' + post.user.display_name" class="rounded wh-12">
          </inertia-link>
        </div>
        <div class="flex-1">
          <div class="flex flex-wrap justify-between">
            <div>
                <i v-if="post.user.id === discussion.user.id" class="fas fa-crown text-muted" :title="post.user.display_name + ' est l\'auteur de ce topic.'"></i></span>
                <i v-if="post.user.is_birthday" class="fas fa-birthday-cake text-muted" :title="'C\'est l\'anniversaire de ' + post.user.display_name + ', aujourd\'hui.'"></i></span>
                <inertia-link :href="route('user.show', post.user.name)" class="inactive">
                  <strong>{{ post.user.display_name }}</strong>
                </inertia-link>
                <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
                <br>
                <inertia-link :href="route('posts.show', post.id)" class="text-xs inactive">
                  {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
                  <span v-if='post.created_at != post.updated_at'>(modifié, {{ moment(post.updated_at).calendar() }})</span>
                </inertia-link>
            </div>
            <div>

            </div>
          </div>
          <hr>
          <div v-html="post.presented_body" class="post"></div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props:[ "discussion", "posts" ],
};
</script>
<template>
  <div class="bg-white shadow rounded mb-4">
    <div class="p-6">
      <inertia-link :href="post.shortlink_url">{{ post.discussion.title }}</inertia-link><br>

      <i class="fas fa-angle-double-left text-muted"></i>
      {{ post.trimmed_body }}
      <i class="fas fa-angle-double-right text-muted"></i>
    </div>
    <hr class="border-b">
    <div class="p-6 flex items-center">
      <img
      :src="post.user.avatar_url"
      :alt="'Avatar de ' + post.user.display_name"
      class="h-6 mr-2" />
      <div>
          <inertia-link :href="route('users.show', post.user.name)" class="">{{ post.user.display_name }}</inertia-link>
          <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
      </div>
      <div class="ml-auto text-sm">
        {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['post']
}
</script>
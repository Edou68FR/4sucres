<template>
  <div class="bg-white shadow rounded mb-4">
    <div class="p-6">
      <inertia-link :href="route('discussions.show', [discussion.id, discussion.slug])">{{ discussion.title }}</inertia-link>
    </div>
    <hr class="border-b">
    <div class="p-6 flex items-center">
      <img
      :src="discussion.user.avatar_url"
      :alt="'Avatar de ' + discussion.user.display_name"
      class="h-6 mr-2" />
      <div>
          <inertia-link :href="route('users.show', discussion.user.name)" class="">{{ discussion.user.display_name }}</inertia-link>
          <span v-if="discussion.user.display_name != discussion.user.name">@{{ discussion.user.name }}</span>
      </div>
      <div class="ml-auto text-sm">
        {{ moment(discussion.created_at).format('L') }} {{ moment(discussion.created_at).format('LTS') }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['discussion']
}
</script>
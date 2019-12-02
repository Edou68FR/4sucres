<template>
  <div class="bg-white shadow rounded mb-4">
    <div class="p-6">
      <div class="flex items-center">
        <img
          :src="user.avatar_url"
          :alt="'Avatar de ' + user.display_name"
          class="h-12 mr-3" />
        <div>
          <inertia-link :href="route('users.show', user.name)" class="">{{ user.display_name }}</inertia-link><br>
          <span class="text-sm">@{{ user.name }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['user']
}
</script>
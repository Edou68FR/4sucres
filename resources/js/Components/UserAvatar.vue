<template>
  <inertia-link :href="route('users.show', user.name)">
    <img
      :src="user.avatar_url"
      :alt="'Avatar de ' + user.display_name"
      class="rounded shadow bg-body"
      :width="wh"
      :height="wh" />
  </inertia-link>
</template>

<script>
export default {
  name: 'UserAvatar',
  props: {
    user: {
        type: Object,
        default: null,
    },
    wh: {
      type: Number,
      default: 32,
    },
  },
};
</script>
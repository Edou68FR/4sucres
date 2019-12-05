<template>
  <span>
    <inertia-link :href="route('users.show', user.name)" class="font-semibold">
      {{ user.display_name }}
    </inertia-link>
    <span v-if="user.display_name != user.name">@{{ user.name }}</span>
  </span>
</template>

<script>
export default {
  name: 'UserName',
  props: {
    user: {
        type: Object,
        default: null,
    }
  },
};
</script>
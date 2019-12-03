<template>
  <button
    class="px-3 py-2 mx-1 rounded"
    :class="{
      'bg-button-primary text-on-button-primary': type == 'primary',
      'bg-button-secondary text-on-button-secondary': type == 'secondary',
      'bg-button-tertiary text-on-button-tertiary': type == 'tertiary',
      'cursor-not-allowed': disabled == true,
    }" v-if="href">
    <slot />
  </button>
  <inertia-link
    class="px-3 py-2 mx-1 rounded"
    :class="{
      'bg-button-primary text-on-button-primary': type == 'primary',
      'bg-button-secondary text-on-button-secondary': type == 'secondary',
      'bg-button-tertiary text-on-button-tertiary': type == 'tertiary',
      'cursor-not-allowed': disabled == true,
    }"
    :href="href"
    v-else>
    <slot />
  </inertia-link>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'primary'
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    href: {
      type: String,
      default: 'undefined'
    }
  }
}
</script>
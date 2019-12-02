<template>
  <button
    class="px-3 py-2 mx-1 rounded"
    :class="{
      'bg-button-primary text-on-button-primary': type == 'primary',
      'bg-button-secondary text-on-button-secondary': type == 'secondary',
    }">
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'primary'
    },
  }
}
</script>
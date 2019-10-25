<template>
  <layout>
    <div class="container mx-auto">
      <div class="card flex-1 markdown p-6 pt-1" v-html="static_page.parsed_content"></div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props: [ "static_page" ],
};
</script>
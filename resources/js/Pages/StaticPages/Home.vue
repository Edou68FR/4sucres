<template>
  <layout>
    <div class="container mx-auto">
      <div class="markdown" v-html="static_page.parsed_content"></div>
      <img src="/img/4sucres_unleashed.png" class="mb-6 h-48">
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
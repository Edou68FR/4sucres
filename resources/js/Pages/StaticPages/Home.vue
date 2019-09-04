<template>
  <layout>
    <img src="/img/4sucres_unleashed.png" class="mx-auto mb-6 h-48">
    <div class="markdown" v-html="static_page.parsed_content"></div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props: [ "static_page" ],
};
</script>
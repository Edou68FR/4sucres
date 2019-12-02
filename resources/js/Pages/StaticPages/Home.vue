<template>
  <layout>
    <div class="container py-6">
      <h1 class="text-xl font-semibold">Bienvenue sur 4sucres.org</h1>
    </div>
    <hr class="border-b">
    <div class="container py-6">
      <div class="markdown" v-html="static_page.parsed_content"></div>
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
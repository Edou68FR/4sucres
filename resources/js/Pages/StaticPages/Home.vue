<template>
  <layout>
    <div class="flex items-center">
      <div class="hidden md:flex mr-8">
        <img src="/img/4sucres_unleashed.png" class="mx-auto w-64">
      </div>
      <div class="card markdown p-4 pt-1" v-html="static_page.parsed_content"></div>
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
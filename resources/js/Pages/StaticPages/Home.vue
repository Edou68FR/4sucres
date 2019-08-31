<template>
  <layout>
    <div class="flex flex-wrap justify-center items-center">
      <div class="mr-8 mb-6 md:mb-0">
        <img src="/img/4sucres_unleashed.png" class="mx-auto w-48 md:w-64">
      </div>
      <div class="card md:flex-1 markdown p-4 pt-1" v-html="static_page.parsed_content"></div>
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
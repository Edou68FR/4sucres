<template>
  <layout>
    <div class="card markdown p-4 pt-1" v-html="static_page.parsed_content"></div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props: [ "static_page" ],
};
</script>
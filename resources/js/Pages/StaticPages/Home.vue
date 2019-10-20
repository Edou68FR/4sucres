<template>
  <layout>
    <div class="header">
        <div class="container mx-auto">
          <div class="page-title">
            <span>Bienvenue sur 4sucres.org</span>
          </div>
        </div>
    </div>
    <div class="container mx-auto">
      <div class="card p-6">
        <!-- <img src="/img/4sucres_unleashed.png" class="mb-6 h-48 "> -->
        <div class="markdown" v-html="static_page.parsed_content"></div>
      </div>
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
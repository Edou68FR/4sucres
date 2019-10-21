<template>
  <layout>
    <div class="container mx-auto">
      <div class="cards">
        <div class="card p-6">
          <div class="page-title">
            <span>Bienvenue sur 4sucres.org</span>
          </div>
        </div>
        <div class="card p-6">
          <!-- <img src="/img/4sucres_unleashed.png" class="mb-6 h-48"> -->
          <div class="markdown" v-html="static_page.parsed_content"></div>
        </div>
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
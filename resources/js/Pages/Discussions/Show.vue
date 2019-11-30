<template>
  <layout>
    <div class="container mx-auto mb-6">

    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import Paginator from "@/Shared/Components/Paginator";
import SimplePaginator from "@/Shared/Components/SimplePaginator";

export default {
  components: { Layout, Paginator, SimplePaginator },
  props: ["discussion", "posts"],
  methods: {
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    }
  }
};
</script>
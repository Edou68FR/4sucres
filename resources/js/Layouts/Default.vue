<template>
  <main>
    <sidebar />
    <!-- <span v-for="static_page in $page.app.static_pages.filter(page => page.position == 1)" v-bind:key="static_page.slug">
      <StaticPageLink :static_page="static_page" class='w-full mx-2 nav-link md:w-auto'></StaticPageLink>
    </span> -->
    <slot />
  </main>
</template>

<script>
import StaticPageLink from '@/Components/StaticPageLink';
import Sidebar from '@/Layouts/Sidebar';

export default {
  name: 'Default',
  components: { StaticPageLink, Sidebar }
}
</script>
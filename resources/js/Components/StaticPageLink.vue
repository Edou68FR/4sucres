<template>
    <inertia-link v-if="static_page.type == 1" :href="route('static_pages.show', static_page.slug)" :class="{ active: route().current('static_pages.show', static_page.slug) }">{{ static_page.name }}</inertia-link>
    <a v-else-if="static_page.type == 2" :href="static_page.href">{{ static_page.name }}</a>
    <a v-else-if="static_page.type == 3" :href="static_page.href" target="_blank">{{ static_page.name }}</a>
</template>

<script>
export default {
    name: 'StaticPageLink',
    props:[ "static_page" ],
};
</script>
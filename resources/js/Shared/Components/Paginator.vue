<template>
    <div class="flex items-center mx-auto">
        <template v-if="paginator.current_page > 1">
            <!-- <inertia-link preserve-scroll :href="paginator.first_page_url"><i class="mr-2 fas fa-angle-double-left"></i></inertia-link> -->
            <inertia-link preserve-scroll :href="paginator.prev_page_url"><i class="fas fa-chevron-left"></i></inertia-link>
        </template>
        <div class="mx-auto text-xs">
            {{ paginator.current_page }} / {{ paginator.last_page }}
        </div>
        <template v-if="paginator.current_page < paginator.last_page">
            <inertia-link preserve-scroll :href="paginator.next_page_url"><i class="fas fa-chevron-right"></i></inertia-link>
            <!-- <inertia-link preserve-scroll :href="paginator.last_page_url"><i class="ml-2 fas fa-angle-double-right"></i></inertia-link> -->
        </template>
    </div>
</template>

<script>
export default {
    name: 'paginator',
    props:[ "paginator" ],
};
</script>
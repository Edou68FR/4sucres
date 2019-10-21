<template>
    <div class="flex w-full items-center">
        <template v-if="paginator.current_page > 1">
            <inertia-link preserve-scroll :href="paginator.first_page_url" class="btn btn-tertiary"><i class="fas fa-angle-double-left"></i></inertia-link>
            <inertia-link preserve-scroll :href="paginator.prev_page_url" class="btn btn-tertiary"><i class="fas fa-angle-left"></i></inertia-link>
        </template>
        <template v-else>
            <span class="btn btn-tertiary disabled" disabled><i class="fas fa-angle-double-left"></i></span>
            <span class="btn btn-tertiary disabled" disabled><i class="fas fa-angle-left"></i></span>
        </template>
        <span class="mx-auto text-sm text-muted">
            {{ paginator.current_page }} / {{ paginator.last_page }}
        </span>
        <template v-if="paginator.current_page < paginator.last_page">
            <inertia-link preserve-scroll :href="paginator.next_page_url" class="btn btn-tertiary"><i class="fas fa-angle-right"></i></inertia-link>
            <inertia-link preserve-scroll :href="paginator.last_page_url" class="btn btn-tertiary"><i class="fas fa-angle-double-right"></i></inertia-link>
        </template>
        <template v-else>
            <span class="btn btn-tertiary disabled" disabled><i class="fas fa-angle-right"></i></span>
            <span class="btn btn-tertiary disabled" disabled><i class="fas fa-angle-double-right"></i></span>
        </template>
    </div>
</template>

<script>
export default {
    name: 'SimplePaginator',
    props:[ "paginator" ],
};
</script>
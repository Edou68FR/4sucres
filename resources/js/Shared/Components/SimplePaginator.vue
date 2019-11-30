<template>
    <div class="flex items-center justify-between">
        <template v-if="paginator.current_page > 1">
            <!-- <a v-on:click="visit(paginator.first_page_url)" class="btn btn-secondary"><i class="fas fa-angle-double-left"></i></a> -->
            <a v-on:click="visit(paginator.prev_page_url)" class="btn btn-secondary"><i class="fas fa-angle-left"></i></a>
        </template>
        <template v-else>
            <!-- <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-double-left"></i></span> -->
            <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-left"></i></span>
        </template>
        <span class="text-muted mx-2">
            {{ paginator.current_page }} / {{ paginator.last_page }}
        </span>
        <template v-if="paginator.current_page < paginator.last_page">
            <a v-on:click="visit(paginator.next_page_url)" class="btn btn-secondary"><i class="fas fa-angle-right"></i></a>
            <!-- <a v-on:click="visit(paginator.last_page_url)" class="btn btn-secondary"><i class="fas fa-angle-double-right"></i></a> -->
        </template>
        <template v-else>
            <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-right"></i></span>
            <!-- <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-double-right"></i></span> -->
        </template>
    </div>
</template>

<script>
export default {
    name: 'SimplePaginator',
    props:[ "paginator", "only" ],
    methods: {
        visit(url) {
            if (this.only) {
                let queryString = url.replace(this.paginator.path, '');
                let currentUrl = window.location.href.split('?')[0];
                this.$inertia.visit(currentUrl + queryString, { only: this.only })
            } else {
                this.$inertia.visit(url)
            }
        }
    }
};
</script>
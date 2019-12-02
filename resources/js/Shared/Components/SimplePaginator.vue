<template>
    <div class="flex items-center justify-between">
        <template v-if="paginator.current_page > 1">
            <!-- <action-button @click.native="visit(paginator.first_page_url)" type="secondary"><i class="fas fa-angle-double-left"></i></action-button> -->
            <action-button @click.native="visit(paginator.prev_page_url)" type="secondary"><i class="fas fa-angle-left"></i></action-button>
        </template>
        <template v-else>
            <!-- <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-double-left"></i></span> -->
            <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-left"></i></span>
        </template>
        <span class="mx-2 text-muted">
            {{ paginator.current_page }} / {{ paginator.last_page }}
        </span>
        <template v-if="paginator.current_page < paginator.last_page">
            <action-button @click.native="visit(paginator.next_page_url)" type="secondary"><i class="fas fa-angle-right"></i></action-button>
            <!-- <action-button @click.native="visit(paginator.last_page_url)" type="secondary"><i class="fas fa-angle-double-right"></i></action-button> -->
        </template>
        <template v-else>
            <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-right"></i></span>
            <!-- <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-double-right"></i></span> -->
        </template>
    </div>
</template>

<script>
import ActionButton from "@/Shared/Components/ActionButton";

export default {
    name: 'SimplePaginator',
    components: { ActionButton },
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
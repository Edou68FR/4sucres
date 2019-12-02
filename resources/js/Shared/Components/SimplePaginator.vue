<template>
    <div class="flex items-center justify-between">
        <template v-if="paginator.current_page > 1">
            <!-- <primary-button @click.native="visit(paginator.first_page_url)" class="btn btn-secondary"><i class="fas fa-angle-double-left"></i></primary-button> -->
            <primary-button @click.native="visit(paginator.prev_page_url)" class="btn btn-secondary"><i class="fas fa-angle-left"></i></primary-button>
        </template>
        <template v-else>
            <!-- <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-double-left"></i></span> -->
            <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-left"></i></span>
        </template>
        <span class="mx-2 text-muted">
            {{ paginator.current_page }} / {{ paginator.last_page }}
        </span>
        <template v-if="paginator.current_page < paginator.last_page">
            <primary-button @click.native="visit(paginator.next_page_url)" class="btn btn-secondary"><i class="fas fa-angle-right"></i></primary-button>
            <!-- <primary-button @click.native="visit(paginator.last_page_url)" class="btn btn-secondary"><i class="fas fa-angle-double-right"></i></primary-button> -->
        </template>
        <template v-else>
            <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-right"></i></span>
            <!-- <span class="btn btn-secondary disabled" disabled><i class="fas fa-angle-double-right"></i></span> -->
        </template>
    </div>
</template>

<script>
import PrimaryButton from "@/Shared/Components/PrimaryButton";

export default {
    name: 'SimplePaginator',
    components: { PrimaryButton },
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
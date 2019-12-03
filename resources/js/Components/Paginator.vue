<template>
    <div class="flex justify-center">
        <div class="px-1" v-for="(page, key) in pageRange" :key="key">
            <inertia-link preserve-scroll :href="(page !== '...') ? paginator.path + '?page=' + page : '#'" class="btn btn-tertiary" :class="{ 'btn-secondary' : page == paginator.current_page, 'text-xs' : page == '...' }">
                {{ page }}
            </inertia-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'paginator',
    props:[ "paginator" ],
    computed: {
        pageRange () {
            let current = this.paginator.current_page;
            let last = this.paginator.last_page;
            let delta = 1;
            let left = current - delta;
            let right = current + delta + 1;
            let range = [];
            let pages = [];
            let l;

            for (let i = 1; i <= last; i++) {
                if (i === 1 || i === last || (i >= left && i < right)) {
                    range.push(i);
                }
            }

            range.forEach(function (i) {
                if (l) {
                    if (i - l === 2) {
                        pages.push(l + 1);
                    } else if (i - l !== 1) {
                        pages.push('...');
                    }
                }
                pages.push(i);
                l = i;
            });

            return pages;
        }
    }
};
</script>
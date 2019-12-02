<template>
  <div>
    <div class="flex flex-col h-screen">
      <div class="border-b flex-start">
        <div class="flex items-center justify-between p-6">
          <div class="page-title">
            <span>Discussions</span>
          </div>
          <div class="flex">
            <simple-paginator :paginator="_.omit(discussions, 'data')" :only="['discussions']"></simple-paginator>
            <button class="mx-1 btn btn-secondary" v-on:click="reload">
              <i class="fas fa-sync"></i>
            </button>
            <inertia-link
              class="btn btn-primary"
              v-if="$page.auth.user && $page.auth.user.permissions.includes('create discussions')"
              :href="route('discussions.create')">
              <i class="fas fa-plus"></i>
            </inertia-link>
          </div>
        </div>
      </div>
      <div class="flex-grow overflow-y-auto" scroll-region>
        <div class="cards">
          <discussion-list-element
            v-for="discussion in discussions.data"
            :key="discussion.id"
            :class="{ selected: (selectedDiscussionId == discussion.id) }"
            :discussion="discussion"
            @click.native="select(discussion)">
          </discussion-list-element>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DiscussionListElement from "@/Pages/Discussions/Components/ListElement";
import SimplePaginator from "@/Shared/Components/SimplePaginator";

export default {
  components: { SimplePaginator, DiscussionListElement },
  props: ['discussions', 'selectedDiscussionId', 'selectParent'],
  methods: {
    select(discussion){
      this.selectParent(discussion);
    },
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    },

  }
}
</script>
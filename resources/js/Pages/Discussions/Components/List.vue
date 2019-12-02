<template>
  <div>
    <div class="flex flex-col h-screen">
      <div class="border-b border-body-border flex-start">
        <div class="flex items-center justify-between p-6">
          <h1 class="text-xl font-semibold">Discussions</h1>
          <div class="flex">
            <simple-paginator :paginator="_.omit(discussions, 'data')" :only="['discussions']" />
            <secondary-button v-on:click="reload">
              <i class="fas fa-sync"></i>
            </secondary-button>
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
        <discussion-list-element
          v-for="discussion in discussions.data"
          :key="discussion.id"
          :class="{ 'shadow-md': (selectedDiscussionId == discussion.id) }"
          :discussion="discussion"
          @click.native="select(discussion)">
        </discussion-list-element>
      </div>
    </div>
  </div>
</template>

<script>
import DiscussionListElement from "@/Pages/Discussions/Components/ListElement";
import SimplePaginator from "@/Shared/Components/SimplePaginator";
import SecondaryButton from "@/Shared/Components/SecondaryButton";
import PrimaryButton from "@/Shared/Components/PrimaryButton";

export default {
  components: { SimplePaginator, DiscussionListElement, SecondaryButton, PrimaryButton },
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
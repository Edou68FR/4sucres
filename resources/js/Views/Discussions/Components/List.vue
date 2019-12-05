<template>
  <div>
    <div class="flex flex-col h-screen">
      <div class="border-b border-body-border flex-start">
        <div class="flex items-center justify-between p-6">
          <h1 class="text-xl font-semibold">Discussions</h1>
          <div class="flex">
            <simple-paginator :paginator="_.omit(discussions, 'data')" :only="['discussions']" />
            <action-button v-on:click="reload" type="secondary">
              <i class="fal fa-sync"></i>
            </action-button>
            <action-button
              v-if="$page.auth.user && $page.auth.user.permissions.includes('create discussions')"
              :href="route('discussions.create')">
              <i class="fal fa-plus"></i>
            </action-button>
          </div>
        </div>
      </div>
      <div class="flex-grow overflow-y-auto" scroll-region>
        <discussion-list-element
          v-for="discussion in discussions.data"
          :key="discussion.id"
          :class="{ 'bg-surface text-on-surface': (selectedDiscussionId == discussion.id) }"
          :discussion="discussion"
          @click.native="select(discussion)">
        </discussion-list-element>
      </div>
    </div>
  </div>
</template>

<script>
import DiscussionListElement from "@/Views/Discussions/Components/ListElement";
import SimplePaginator from "@/Components/SimplePaginator";
import ActionButton from "@/Components/ActionButton";

export default {
  components: { SimplePaginator, DiscussionListElement, ActionButton },
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
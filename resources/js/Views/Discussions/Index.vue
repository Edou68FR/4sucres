<template>
  <layout>
    <div class="flex">
      <discussion-list
        class="w-full lg:border-r md:block md:w-1/2 lg:w-1/3 border-body-border"
        :class="{ hidden: selectedDiscussionId && discussion }"
        :discussions="discussions"
        :selected-discussion-id="selectedDiscussionId"
        :select-parent="select">
      </discussion-list>
      <discussion-show
        class="w-full md:block md:w-1/2 lg:w-2/3"
        :class="{ hidden: !selectedDiscussionId && !discussion }"
        :discussion="discussion"
        v-if="selectedDiscussionId"
        :unselect-parent="unselect">
      </discussion-show>
      <div class="hidden md:w-1/2 lg:w-2/3 md:block" v-else>
        <div class="flex items-center justify-center h-screen">
          <img src="/img/4sucres_white_white.png" alt="Logo 4sucres">
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layouts/Default";
import SimplePaginator from "@/Components/SimplePaginator";
import DiscussionList from "@/Views/Discussions/Components/List";
import DiscussionShow from "@/Views/Discussions/Components/Show";

export default {
  components: { Layout, SimplePaginator, DiscussionList, DiscussionShow },
  props: ["discussions", "discussion", "posts"],
  data(){
    return {
      selectedDiscussionId: undefined,
    }
  },
  mounted(){
    if (this.discussion) {
      this.selectedDiscussionId = this.discussion.id;
    }
  },
  methods: {
    unselect(){
      history.pushState(null, null, route('discussions.index') + '?browse=' + this.discussions.current_page);
      this.selectedDiscussionId = undefined;
    },
    select(discussion, $event) {
      this.selectedDiscussionId = discussion.id;
      this.$inertia.visit(
        route('discussions.show', [discussion.id, discussion.slug]),
        {
          preserveScroll: true,
          only: ['discussion']
        }
      );
    },
  }
};
</script>
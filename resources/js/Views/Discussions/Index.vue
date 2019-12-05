<template>
  <layout>
    <div class="flex">
      <discussion-list
        class="w-full lg:border-r md:block md:w-1/2 lg:w-1/3 border-body-border"
        :class="{ hidden: currentDiscussion }"
        :discussions="discussions"
        :current-discussion="currentDiscussion"
        :select-parent="select">
      </discussion-list>
      <discussion-show
        class="w-full md:block md:w-1/2 lg:w-2/3"
        :class="{ hidden: !currentDiscussion }"
        :discussion="currentDiscussion"
        v-if="currentDiscussion"
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
      currentDiscussion: undefined,
    }
  },
  mounted(){
    if (this.discussion) {
      this.currentDiscussion = this.discussion;
    }
  },
  methods: {
    unselect(){
      history.pushState(null, null, route('discussions.index') + '?browse=' + this.discussions.current_page);
      this.currentDiscussion = undefined;
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
  },
  watch: {
    discussion: {
      handler: (discussion) => this.currentDiscussion = discussion,
      deep: true,
    },
  }
};
</script>
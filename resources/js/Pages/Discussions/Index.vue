<template>
  <layout>
    <div class="flex">
      <discussion-list
        class="w-full lg:block lg:w-1/3"
        :class="{ hidden: selectedDiscussionId }"
        :discussions="discussions"
        :selected-discussion-id="selectedDiscussionId"
        :select-parent="select">
      </discussion-list>
      <discussion-show
        class="w-full lg:block lg:w-2/3 content"
        :class="{ hidden: !selectedDiscussionId }"
        :discussion="discussion"
        v-if="selectedDiscussionId"
        :unselect-parent="unselect">
      </discussion-show>
      <div class="hidden lg:block w-2/3 content" v-else>
        <div class="flex h-screen items-center justify-center">
          <img src="/img/4sucres_white_white.png" alt="Logo 4sucres">
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";
import SimplePaginator from "@/Shared/Components/SimplePaginator";
import DiscussionList from "@/Pages/Discussions/Components/List";
import DiscussionShow from "@/Pages/Discussions/Components/Show";

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
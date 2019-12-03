<template>
<div>
  <div class="flex flex-col h-screen">
    <div class="border-b flex-start border-body-border">
      <div class="flex flex-wrap items-center justify-between p-6 lg:order-1">
        <action-button class="mr-6 lg:hidden" @click.native="unselect" type="secondary">
          <i class="fas fa-angle-left"></i> Retour
        </action-button>
        <div class="flex justify-end flex-none lg:order-3">
          <simple-paginator :paginator="_.omit(discussion.posts, 'data')" :only="['discussion']" />
          <template v-if="$page.auth.user">
            <action-button href="#">
              <i class="fas fa-plus"></i><span class="hidden sm:inline">Répondre</span>
            </action-button>
            <action-button :href="route('discussions.unsubscribe', [discussion.id, discussion.slug])">
              <i class="far fa-star"></i>
            </action-button>
          </template>
          <action-button @click.native="reload" type="secondary">
            <i class="fas fa-sync"></i>
          </action-button>
        </div>
        <h1 class="w-full mt-6 text-xl font-semibold text-center lg:order-2 lg:w-auto lg:mt-0">
          {{ discussion.title }}
        </h1>
      </div>
    </div>
    <div class="flex-grow overflow-y-auto" scroll-region>
      <reply
        v-for="post in discussion.posts.data"
        :key="post.id"
        :post="post" />
    </div>
  </div>
</div>
</template>

<script>
import DiscussionListElement from "@/Pages/Discussions/Components/ListElement";
import SimplePaginator from "@/Shared/Components/SimplePaginator";
import ActionButton from "@/Shared/Components/ActionButton";
import Reply from "@/Pages/Discussions/Components/Show/Reply";

export default {
  components: { SimplePaginator, DiscussionListElement, ActionButton, Reply },
  props: ['discussion', 'unselectParent'],
  methods: {
    unselect(){
      this.unselectParent();
    },
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    },
  }
}
</script>
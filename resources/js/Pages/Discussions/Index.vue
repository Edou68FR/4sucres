<template>
  <layout>
    <h1>Discussions</h1>
    <div class="card shadow-sm mb-3 discussion-previews">
      <div class="discussion-preview" v-for="discussion in discussions.data" :key="discussion.id">
        <div class="row align-items-center px-3 py-2 d-flex">
          <div class="col overflow-ellipsis">
            <div class="discussion-title overflow-ellipsis mb-2 mb-lg-0">
              <a
                :href="route('discussions.show', [discussion.id, discussion.slug])"
              >{{ discussion.title }}</a>
            </div>
            <div class="text-small overflow-ellipsis">
              par
              <a
                :href="route('user.show', discussion.user.name)"
              >{{ discussion.user.display_name }}</a>
              {{ discussion.created_at }}
            </div>
          </div>
          <div class="col-12 overflow-ellipsis border-none col-lg-fixed last-activity text-small">
            <div class="row align-items-center no-gutters">
              <div class="col-auto d-none d-lg-flex"></div>
              <div class="col overflow-ellipsis">
                <div class="d-inline d-lg-block">
                  <a
                    :href="route('user.show', discussion.latest_post.user.name)"
                  >{{ discussion.latest_post.user.display_name }}</a>
                </div>
                <div class="d-none d-lg-block mb-lg-1">
                  <a
                    :href="route('posts.show', discussion.latest_post.id)"
                  >{{ discussion.latest_post.created_at }}</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 border-none col-lg-fixed replies-counter text-small">
            <i
              class="far fw-fw mr-1 d-none d-ld-none d-lg-inline"
              :class="{
                  'text-red' : discussions.replies > 10,
                  'fa-comments' : (discussion.replies > 1),
                  'fa-comment' : (discussion.replies <= 1),
                }"
            ></i>
            {{ discussion.replies }}
          </div>
        </div>
      </div>
    </div>
    <div class="flex">
      <div>{{ discussions.current_page }} / {{ discussions.last_page }}</div>
      <div class="ml-auto">
        <inertia-link :href="discussions.first_page_url">Début</inertia-link>
        <inertia-link :href="discussions.prev_page_url">Précédent</inertia-link>
        <inertia-link :href="discussions.next_page_url">Suivant</inertia-link>
        <inertia-link :href="discussions.last_page_url">Dernière</inertia-link>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: {
    Layout
  },
  props: {
    categories: Array,
    sticky_discussions: Array,
    discussions: Object,
    user_has_read: Array
  },
  mounted: function() {
    console.log(this.discussions);
  }
};
</script>
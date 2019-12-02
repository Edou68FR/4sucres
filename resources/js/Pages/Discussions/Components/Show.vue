<template>
<div>
  <div class="flex flex-col h-screen">
    <div class="flex-start">
      <div class="flex items-center justify-between p-6">
        <div class="flex-grow m-w-0">
          <div class="page-title" v-html="discussion.title"></div>
        </div>
        <div class="flex-none">
          <button class="mx-1 btn btn-primary" href="#" @click="unselect">
            <i class="inline-block sm:hidden fas fa-plus"></i>
            <span class="hidden sm:inline">Retour</span>
          </button>
          <template v-if="$page.auth.user">
            <inertia-link class="mx-1 btn btn-primary" href="#">
              <i class="inline-block sm:hidden fas fa-plus"></i>
              <span class="hidden sm:inline">Répondre</span>
            </inertia-link>
            <inertia-link
              class="mx-1 btn btn-secondary"
              :href="route('discussions.unsubscribe', [discussion.id, discussion.slug])"
            >
              <i class="far fa-star"></i>
            </inertia-link>
          </template>
          <button class="mx-1 btn btn-secondary" v-on:click="reload">
            <i class="fas fa-sync"></i>
          </button>
        </div>
      </div>
      <simple-paginator class="mt-6" :paginator="_.omit(discussion.posts, 'data')" :only="['discussion']"></simple-paginator>
    </div>
    <div class="flex-grow overflow-y-auto" scroll-region>
      <div v-for="post in discussion.posts.data" :key="post.id" class="card flex-1">
        <div class="flex items-center px-6 py-4">
          <inertia-link :href="route('users.show', post.user.name)" class="hidden sm:block wh-10 mr-4">
            <img
              :src="post.user.avatar_url"
              :alt="'Avatar de ' + post.user.display_name"
              class="rounded wh-10 shadow" />
          </inertia-link>
          <div>
            <inertia-link :href="route('users.show', post.user.name)">
              <strong>{{ post.user.display_name }}</strong>
            </inertia-link>
            <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
            <br>
            <inertia-link :href="post.shortlink_url" class="text-sm">
              {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
              <span
                v-if="post.created_at != post.updated_at"
              >(modifié, {{ moment(post.updated_at).calendar() }})</span>
            </inertia-link>
          </div>
          <div class="ml-auto">
            <inertia-link href="#" class="btn btn-sm btn-tertiary">
              <i class="fas fa-quote-right"></i>
            </inertia-link>
            <template v-if="$page.auth.user">
              <inertia-link
                v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                :href="route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])"
                class="btn btn-sm btn-tertiary">
                <i class="fas fa-edit"></i>
              </inertia-link>
              <inertia-link
                v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                :href="route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])"
                class="btn btn-sm btn-tertiary">
                <i class="fas fa-trash"></i>
              </inertia-link>
            </template>
          </div>
        </div>
        <hr>
        <div v-html="post.presented_body" class="post p-6" v-if="!post.deleted_at"></div>
        <div class="p-6 text-red-600" v-if="post.deleted_at">
          <i class="fas fa-times mr-1"></i> Ce message a été supprimé
        </div>
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
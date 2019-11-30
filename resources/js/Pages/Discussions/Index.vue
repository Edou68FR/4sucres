<template>
  <layout>
    <div class="flex">
      <div class="w-full md:block md:w-1/3" :class="{ hidden: discussion }" >
        <div class="flex flex-col h-screen">
          <div class="flex-start border-b">
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
              <div
                class="card hoverable px-4 py-2"
                :class="{ selected: discussion.selected }"
                v-for="discussion in discussions.data"
                :key="discussion.id"
                v-on:click="select(discussion, $event)">
                <div class="flex items-center">
                  <div class="mr-4 flex-none">
                    <div class="badge bg-gold-600"
                      :class="{
                        'bg-red-600' : (discussion.replies >= 10),
                        'bg-gray-600' : (discussion.locked),
                        'bg-green-600' : (discussion.sticky),
                      }">
                      <i
                        class="fas fa-folder"
                        style="width: 1em;"
                        :class="{
                            'fa-lock' : (discussion.locked),
                            'fa-thumbtack' : (discussion.sticky),
                            'fa-shield-alt' : (discussion.private),
                          }"
                      ></i>
                    </div>
                  </div>
                  <div class="m-w-0 md:flex-1 flex flex-wrap md:flex-no-wrap items-center">
                    <div class="m-w-0">
                      <div class="truncate">
                        <inertia-link
                          :href="route('discussions.show', [discussion.id, discussion.slug])"
                          class="font-bold accent"
                          v-html="discussion.title"
                        ></inertia-link>
                      </div>
                      <div class="truncate text-sm">
                        le {{ moment(discussion.created_at).calendar() }}
                        par
                        <inertia-link
                          :href="route('users.show', discussion.user.name)"
                        >{{ discussion.user.display_name }}</inertia-link>
                      </div>
                    </div>
                  </div>
                  <div class="w-12 md:w-32 lg:w-40 ml-auto flex-none flex flex-wrap items-center text-sm text-center md:text-right m-w-0">
                    <div class="w-full md:flex-1 truncate md:ml-0 md:mr-4"
                      :class="{'font-bold text-red-600': ($page.auth.user && !discussion.has_seen)}">
                      <inertia-link
                        :href="route('users.show', discussion.latest_post.user.name)"
                        class="hidden md:inline"
                      >{{ discussion.latest_post.user.display_name }}</inertia-link>
                      <br class="hidden md:block" />
                      <inertia-link :href="route('posts.show', discussion.latest_post.id)">
                        <span class="hidden md:inline">il y a</span>
                        {{ moment(discussion.latest_post.created_at).fromNow().replace('il y a ', '') }}
                      </inertia-link>
                    </div>
                    <div class="mx-auto">
                      <img
                        :src="discussion.latest_post.user.avatar_url"
                        :alt="'Avatar de ' + discussion.latest_post.user.display_name"
                        class="rounded wh-10 shadow"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full md:block md:w-2/3 content" :class="{ hidden: !discussion }" v-if="discussion">
        <div class="flex flex-col h-screen">
          <div class="flex-start">
            <div class="flex items-center justify-between p-6">
              <div class="flex-grow m-w-0">
                <div class="page-title" v-html="discussion.title"></div>
              </div>
              <div class="flex-none">
                <button class="mx-1 btn btn-primary" href="#" v-on:click="clear">
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
      <div class="hidden md:block w-2/3 content" v-else>
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

export default {
  components: { Layout, SimplePaginator },
  props: ["discussions", "discussion", "posts"],
  mounted(){
    if (this.discussion) {
      this.discussions.data.map((discussion) => {
        discussion.selected = (discussion.id == this.discussion.id);
      });
    }
  },
  methods: {
    visit(url, $event) {
      if (!$event.srcElement.matches("a")) this.$inertia.visit(url);
    },
    reload() {
      this.$inertia.reload({ preserveScroll: true });
    },
    clear(){
      history.pushState(null, null, route('discussions.index') + '?browse=' + this.discussions.current_page);
      this.discussion = null;
    },
    select(discussion, $event) {
      this.discussions.data.map((discussion) => discussion.selected = false);
      discussion.selected = true;

      this.$inertia.visit(route('discussions.show', [discussion.id, discussion.slug]), {
        only: ['discussion']
      })
    },
  }
};
</script>
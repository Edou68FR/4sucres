<template>
  <layout>
    <div class="container mx-auto">
      <div class="card p-6 mb-6">
        <div class="flex justify-between items-center">
          <div class="page-title">Recherche</div>
          <div>
            <input type="text" name="q" class="form-control inline w-64" v-model="form.q" :disabled="loading">
            <select class="form-control inline w-48" v-model="form.scope">
              <option value="discussions">Discussions</option>
              <option value="posts">Posts</option>
              <option value="users">Membres</option>
            </select>
            <button type="submit" class="btn btn-primary" v-on:click="submit()"><i class="fas fa-search mr-1"></i> Recherche</button>
          </div>
        </div>
      </div>
      <div class="cards" ref="results">
        <template v-if="discussions">
          <template v-if="discussions.data.length">
            <div class="card p-6" v-for="discussion in discussions.data" v-bind:key="discussion.id">
              <div class="block">
                <inertia-link :href="route('discussions.show', [discussion.id, discussion.slug])">{{ discussion.title }}</inertia-link>
              </div>
              <hr class="my-4">
              <div class="flex items-center">
                  <img
                    :src="discussion.user.avatar_url"
                    :alt="'Avatar de ' + discussion.user.display_name"
                    class="h-6 mr-2" />
                    <div>
                      <inertia-link :href="route('users.show', discussion.user.name)" class="">{{ discussion.user.display_name }}</inertia-link>
                      <span v-if="discussion.user.display_name != discussion.user.name">@{{ discussion.user.name }}</span>
                    </div>
                  <div class="ml-auto text-sm">
                    {{ moment(discussion.created_at).format('L') }} {{ moment(discussion.created_at).format('LTS') }}
                  </div>
              </div>
            </div>
          </template>
          <div v-else class="card p-6 text-red-600">
            Ta recherche n'a donné aucun résultat 😅
          </div>
        </template>
        <template v-if="posts">
          <template v-if="posts.data.length">
            <div class="card p-6" v-for="post in posts.data" v-bind:key="post.id">
              <div class="block">
                <inertia-link :href="post.shortlink_url">{{ post.discussion.title }}</inertia-link><br>

                <i class="fas fa-angle-double-left text-muted"></i>
                {{ post.trimmed_body }}
                <i class="fas fa-angle-double-right text-muted"></i>
              </div>
              <hr class="my-4">
              <div class="flex items-center">
                  <img
                    :src="post.user.avatar_url"
                    :alt="'Avatar de ' + post.user.display_name"
                    class="h-6 mr-2" />
                    <div>
                      <inertia-link :href="route('users.show', post.user.name)" class="">{{ post.user.display_name }}</inertia-link>
                      <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
                    </div>
                  <div class="ml-auto text-sm">
                    {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
                  </div>
              </div>
            </div>
          </template>
          <div v-else class="card p-6 text-red-600">
            Ta recherche n'a donné aucun résultat 😅
          </div>
        </template>
        <template v-if="users">
          <template v-if="users.data.length">
            <div class="card p-6" v-for="user in users.data" v-bind:key="user.id">
              <div class="flex items-center">
                  <img
                    :src="user.avatar_url"
                    :alt="'Avatar de ' + user.display_name"
                    class="h-12 mr-3" />
                  <div>
                    <inertia-link :href="route('users.show', user.name)" class="">{{ user.display_name }}</inertia-link><br>
                    <span class="text-sm">@{{ user.name }}</span>
                  </div>
              </div>
            </div>
          </template>
          <div v-else class="card p-6 text-red-600">
            Ta recherche n'a donné aucun résultat 😅
          </div>
        </template>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props: ["q", "scope", "discussions", "posts", "users"],
  data() {
    return {
      errors: [],
      form: {
        q: '',
        scope: '',
      },
      loading: false,
    };
  },
  mounted() {
    this.form.q = this.$props.q;
    this.form.scope = this.$props.scope;
  },
  methods: {
    submit() {
      if (this.loading) return;
      this.loading = true;
      this.$inertia.visit(this.route('search'), { data: this.form });
    }
  }
};
</script>
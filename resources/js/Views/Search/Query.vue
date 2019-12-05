<template>
  <layout>
    <div class="container py-6">
      <h1 class="text-xl font-semibold">Recherche</h1>
    </div>
    <hr class="border-b">
    <div class="container py-6">
      <input type="text" name="q" class="form-control inline w-64" v-model="form.q" :disabled="loading">
      <select class="form-control inline w-48" v-model="form.scope">
        <option value="discussions">Discussions</option>
        <option value="posts">Réponses</option>
        <option value="users">Membres</option>
      </select>
      <button type="submit" class="btn btn-primary" v-on:click="submit()"><i class="fal fa-search mr-1"></i> Recherche</button>
    </div>
    <div class="container py-6">
      <div ref="results">
        <template v-if="discussions">
          <template v-if="discussions.data.length">
              <discussion-result
                v-for="discussion in discussions.data"
                v-bind:key="discussion.id"
                :discussion="discussion">
              </discussion-result>
          </template>
          <div v-else class="card p-6 text-red-600">
            Ta recherche n'a donné aucun résultat 😅
          </div>
        </template>
        <template v-if="posts">
          <template v-if="posts.data.length">
            <entry-result
              v-for="post in posts.data"
              v-bind:key="post.id"
              :post="post">
            </entry-result>
          </template>
          <div v-else class="card p-6 text-red-600">
            Ta recherche n'a donné aucun résultat 😅
          </div>
        </template>
        <template v-if="users">
          <template v-if="users.data.length">
             <user-result
              v-for="user in users.data"
              v-bind:key="user.id"
              :user="user">
            </user-result>
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
import Layout from "@/Layouts/Default";
import DiscussionResult from "@/Views/Search/Components/DiscussionResult";
import EntryResult from "@/Views/Search/Components/EntryResult";
import UserResult from "@/Views/Search/Components/UserResult";

export default {
  components: { Layout, DiscussionResult, EntryResult, UserResult },
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
<template>
  <div class="flex-1 mb-2 border-b border-body-border">
    <div class="flex items-center px-6 py-4">
      <inertia-link :href="route('users.show', post.user.name)" class="mr-4 wh-10">
        <img
          :src="post.user.avatar_url"
          :alt="'Avatar de ' + post.user.display_name"
          class="rounded shadow wh-10" />
      </inertia-link>
    <div>
      <inertia-link :href="route('users.show', post.user.name)">
        <strong>{{ post.user.display_name }}</strong>
      </inertia-link>
      <span v-if="post.user.display_name != post.user.name">@{{ post.user.name }}</span>
      <br>
      <inertia-link :href="post.shortlink_url" class="text-sm">
        {{ moment(post.created_at).format('L') }} {{ moment(post.created_at).format('LTS') }}
        <span v-if="post.created_at != post.updated_at">
          (modifié, {{ moment(post.updated_at).calendar() }})
        </span>
      </inertia-link>
    </div>
    <div class="ml-auto">
       <popper trigger="click" :options="{ placement: 'right-end', modifiers: {preventOverflow :{ boundariesElement: 'window'  }}}">
        <div class="popper">
          <ul>
            <li><i class="fas fa-quote-left"></i> Citer</li>
            <template v-if="$page.auth.user">
              <li>
                <inertia-link
                  v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                  :href="route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])"
                  class="btn btn-sm btn-tertiary">
                    <i class="fas fa-edit"></i> Modifier
                </inertia-link>
              </li>
              <li>
                <inertia-link
                  v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                  :href="route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])"
                  class="btn btn-sm btn-tertiary">
                  <i class="fas fa-trash"></i> Supprimer
                </inertia-link>
              </li>
            </template>
          </ul>
        </div>
        <button slot="reference">
          <action-button type="tertiary">
            <i class="fas fa-ellipsis-v"></i>
          </action-button>
        </button>
      </popper>
    </div>
  </div>
  <hr class="border-b b-1 border-body-border">
  <div v-html="post.presented_body" class="p-6 post" v-if="!post.deleted_at"></div>
    <div class="p-6 text-red-600" v-if="post.deleted_at">
      <i class="mr-1 fas fa-times"></i> Ce message a été supprimé
    </div>
  </div>
</template>

<script>
import ActionButton from '@/Shared/Components/ActionButton.vue'
import Popper from 'vue-popperjs';

export default {
  components: { Popper, ActionButton },
  props: ['post']
}
</script>
<template>
  <div class="flex-1 mb-2 border-b border-body-border">
    <div class="flex items-center px-6 py-4">
      <user-avatar :user="post.user" class="mr-4" />
      <div>
        <user-name :user="post.user" />
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
              <li><i class="fal fa-quote-left"></i> Citer</li>
              <template v-if="$page.auth.user">
                <li>
                  <inertia-link
                    v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                    :href="route('discussions.posts.edit', [discussion.id, discussion.slug, post.id])"
                    class="btn btn-sm btn-tertiary">
                      <i class="fal fa-edit"></i> Modifier
                  </inertia-link>
                </li>
                <li>
                  <inertia-link
                    v-if="$page.auth.user.id == post.user.id || $page.auth.user.permissions.includes('bypass discussions guard')"
                    :href="route('discussions.posts.delete', [discussion.id, discussion.slug, post.id])"
                    class="btn btn-sm btn-tertiary">
                    <i class="fal fa-trash"></i> Supprimer
                  </inertia-link>
                </li>
              </template>
            </ul>
          </div>
          <button slot="reference">
            <action-button type="tertiary">
              <i class="fal fa-ellipsis-v"></i>
            </action-button>
          </button>
        </popper>
      </div>
    </div>
    <hr class="border-body-border">
    <div class="p-6">
      <div class="user-content" v-html="post.presented_body"  v-if="!post.deleted_at" />
      <div v-else><i class="mr-1 fal fa-times"></i> Ce message a été supprimé</div>
    </div>
  </div>
</template>

<script>
import ActionButton from '@/Components/ActionButton'
import Popper from 'vue-popperjs';
import UserAvatar from '@/Components/UserAvatar';
import UserName from '@/Components/UserName';

export default {
  components: { Popper, ActionButton, UserAvatar, UserName },
  props: ['post', 'discussion']
}
</script>
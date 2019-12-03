<template>
  <div class="rounded shadow bg-surface text-on-surface">
    <div v-html="post.presented_body" class="p-6" v-if="!post.deleted_at"></div>
    <div class="p-6" v-if="post.deleted_at"><i class="mr-1 fas fa-times"></i> Ce message a été supprimé</div>
  </div>
</template>

<script>
import UserAvatar from '@/Components/UserAvatar';
import UserName from '@/Components/UserName';

export default {
  props: ['post']
}
</script>
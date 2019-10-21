<template>
  <layout>
    <div class="container mx-auto mb-6">
      <div class="cards">
        <div class="card p-6">
          <div class="flex items-center justify-between">
            <div class="page-title">
              <span>Membres</span>
              <span class="text-muted mx-1">/</span>
              <span>{{ user.name }}</span>
            </div>
            <div class="ml-auto" v-if="$page.auth.user">
              <inertia-link v-if="user.id != $page.auth.user.id" :href="route('private_discussions.create', [user.id, user.name])" class="btn btn-primary">Envoyer un message privé</inertia-link>
              <inertia-link v-if="user.id == $page.auth.user.id" :href="route('user.settings.profile')" class="btn btn-secondary">Paramètres</inertia-link>
                <!-- <inertia-link v-if="$page.auth.user.permissions.includes('impersonate users')" :href="route('user.delete', user.name)" class="btn btn-secondary">Imiter</inertia-link>
                <inertia-link v-if="$page.auth.user.permissions.includes('delete users')" :href="route('user.delete', user.name)" class="btn btn-secondary">Supprimer l'utilisateur</inertia-link>  -->
            </div>
          </div>
        </div>
        <div class="card">
          <div class="flex flex-wrap justify-center items-center p-6">
            <img :src="user.avatar_url" class="rounded wh-24 mb-4 sm:mb-0">
            <div class="w-full text-center sm:text-left sm:w-auto sm:ml-5">
              <div class="mb-2">
                <span class="font-bold">{{ user.display_name }}</span>
                <span v-if="user.display_name != user.name">@{{ user.name }}</span>
                <span class="badge badge-primary" v-if="google_2fa_enabled"><i class="fas fa-lock"></i> 2FA</span>
              </div>
              <div class="mb-2">
                <span class="text-base font-bold">{{ user.discussions_count }}</span> discussions
                <br class="sm:hidden">
                <span class="text-base font-bold">{{ user.replies_count }}</span> réponses
              </div>

              <span class="font-bold">Titre :</span> {{ user.shown_role }}<br>
              <span class="font-bold">Membre depuis :</span> {{ seniority }} ({{ moment(user.created_at).format('L') }})<br>
              <span class="font-bold">Dernière activité :</span> {{ moment(user.last_activity).calendar() }}<br>
            </div>
          </div>

          <hr>

          <div v-if="bans.length" class="p-6">
            <div class="font-bold mb-2">Sanctions :</div>
            <div class="card p-2 mb-1" v-for="ban in bans">
              <span v-if="ban.created_at == ban.expired_at" class="font-bold text-yellow-600">Avertissement</span>
              <span v-else class="font-bold text-red-600">Bannissement {{ ban.expired_at ? 'temporaire' : 'définitif' }}</span>
              <br>
              <span v-if="ban.comment">{{ ban.comment }}</span><br>
              <span class="text-xs text-muted">Sanctionné le {{ moment(ban.created_at).format('L') }}</span>
            </div>
          </div>

          <div v-if="achievements.length" class="p-6">
            <div class="font-bold mb-2">Succès :</div>
            <div class="flex flex-wrap -m-1">
              <div class="card w-full sm:w-auto p-4 m-1" v-for="achievement in achievements" :title="achievement.name + ' : ' + achievement.description + ' (' + moment(achievement.unlocked_at).format('L') + ')'" v-bind:key="achievement.id">
                <div class="font-bold mb-2 sm:mb-0"><img :src="achievement.image_url" class="inline-block wh-8 mr-1"> {{ achievement.name }}</div>
                <div class="sm:hidden">
                {{ achievement.description }}<br>
                <span class="text-xs text-muted">Obtenu le {{ moment(achievement.unlocked_at).format('L') }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props: [ "user", "bans", "achievements", "seniority", "google_2fa_enabled" ],
};
</script>
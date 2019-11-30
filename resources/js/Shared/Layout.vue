<template>
  <main>
    <aside :class="{'animated slideInLeft faster': asideAnimation.value}" class="flex flex-col">
      <div class="flex-start flex-grow">
        <div class="aside-brand">
          <inertia-link :href="route('discussions.index')">
            <img src="/img/icons/apple-touch-icon-120x120.png" alt="Logo 4sucres.org" class="mx-auto h-10">
          </inertia-link>
        </div>
        <ul class="aside-nav">
          <li><inertia-link :href="route('home')" :class="{ active: route().current('home') }"><i class="fas fa-home"></i></inertia-link></li>
          <li><inertia-link :href="route('discussions.index')" :class="{ active: route().current('discussions*') }"><i class="fas fa-folder"></i></inertia-link></li>
          <li><inertia-link :href="route('search')" :class="{ active: route().current('search') }"><i class="fas fa-search"></i></inertia-link></li>
        </ul>
      </div>
      <div class="flex-end">
        <ul class="aside-nav">
          <template v-if="$page.auth.user">
            <li>
              <popper
              trigger="click"
              :options="{ placement: 'right-end', modifiers: {preventOverflow :{ boundariesElement: 'window'  }}}">
              <div class="popper">
                <template v-if="$page.auth.user.notifications.length">
                  <ul>
                    <li v-for="(notification) in $page.auth.user.notifications.slice(0, 7)" v-bind:key="notification.id">
                      <inertia-link :href="route('notifications.show', notification.id)">
                        <div v-html="notification.data.html"></div>
                        <span class="text-xs text-muted">{{ moment(notification.created_at).calendar() }}</span>
                      </inertia-link>
                    </li>
                  </ul>
                  <hr>
                  <ul>
                    <li><inertia-link :href="route('notifications.index')">Voir tout</inertia-link></li>
                    <li><inertia-link :href="route('notifications.clear')">Tout marquer comme lu</inertia-link></li>
                  </ul>
                </template>
                <div class="p-6 text-center" v-else>
                  <img src="/svg/sucre_sad.svg" class="mx-auto h-24 mb-4">
                  Aucune notification
                </div>
              </div>
              <button class="relative" slot="reference">
                <i class="fas fa-bell"></i>
                <span v-if="$page.auth.user.notifications.length" class="absolute badge badge-danger" style="bottom: .25rem; right: .75rem;">{{ $page.auth.user.notifications.length }}</span>
              </button>
            </popper>

            </li>
            <li>
              <inertia-link :href="route('home')" class="relative">
                <i class="fas fa-envelope"></i>
                <span v-if="$page.auth.user.private_unread_count" class="absolute badge badge-primary" style="bottom: .25rem; right: .75rem;">{{ $page.auth.user.private_unread_count }}</span>
              </inertia-link>
            </li>
            <li><button><i class="fas fa-lightbulb"></i></button></li>
            <li v-if="$page.auth.user.roles.includes('admin') || $page.auth.user.roles.includes('moderator')">
              <inertia-link :href="route('admin.index')" :class="{ active: route().current('admin.index') }"><i class="fas fa-lock"></i></inertia-link>
            </li>
          </template>

          <li>
            <popper
              trigger="click"
              :options="{ placement: 'right-end', modifiers: {preventOverflow :{ boundariesElement: 'window'  }}}">
              <div class="popper">
                <div class="p-6">
                  <div class="font-bold">
                    {{ $page.app.name }} <span class="badge">{{ $page.app.version }}</span>
                  </div>
                  <div class="mb-2">
                    Parce qu'à 2 on était pas assez.<br>
                    &copy; 2019-2020
                  </div>
                  <div class="text-muted">
                    Temps d'exécution : <span :title="$page.app.real_runtime + 's'">{{ $page.app.runtime }}s</span>
                  </div>
                </div>
                <hr>
                <ul>
                  <li v-for="(static_page) in footer_pages = $page.app.static_pages.filter(page => page.position == 3)" v-bind:key="static_page.slug">
                    <StaticPageLink :static_page="static_page"></StaticPageLink>
                  </li>
                </ul>
              </div>
              <button slot="reference">
                <i class="fas fa-question-circle"></i>
              </button>
            </popper>
          </li>

          <template>
            <li>
              <popper
                trigger="click"
                :options="{ placement: 'right-end' }">
                <div class="popper">
                  <template v-if="$page.auth.user">
                    <div class="flex items-center px-4 py-4">
                      <img :src="$page.auth.user.avatar_url" :alt="'Avatar de ' + $page.auth.user.name" class="rounded wh-8 shadow">
                      <div class="ml-2 flex-1" style="line-height: 1.1em;">
                        <span class="font-bold">{{ $page.auth.user.display_name }}</span><br>
                        <span class="text-xs text-muted">{{ $page.auth.user.email }}</span>
                      </div>
                    </div>
                    <hr>
                    <ul>
                      <li><inertia-link :href="route('users.me')">Profil</inertia-link></li>
                      <li><inertia-link :href="route('user.settings.profile')">Paramètres</inertia-link></li>
                      <li><inertia-link :href="route('logout')" method="post">Déconnexion</inertia-link></li>
                    </ul>
                  </template>
                  <template v-else>
                    <ul>
                      <li><inertia-link :href="route('register')" :class="{ active: route().current('register') }">Inscription</inertia-link></li>
                      <li><inertia-link :href="route('login')" :class="{ active: route().current('login') }">Connexion</inertia-link></li>
                    </ul>
                  </template>
                </div>
                <button slot="reference">
                  <img v-if="$page.auth.user" :src="$page.auth.user.avatar_url" :alt="'Avatar de ' + $page.auth.user.name" class="mx-auto rounded wh-8">
                  <img v-else src="/img/guest.png" alt="Avatar Invité" class="mx-auto rounded wh-8">
                </button>
              </popper>
            </li>
          </template>
        </ul>
      </div>
    </aside>

    <!-- <span v-for="static_page in $page.app.static_pages.filter(page => page.position == 1)" v-bind:key="static_page.slug">
      <StaticPageLink :static_page="static_page" class='mx-2 nav-link w-full md:w-auto'></StaticPageLink>
    </span> -->

    <slot />
  </main>
</template>

<script>
import StaticPageLink from '@/Shared/Components/StaticPageLink';
import Popper from 'vue-popperjs';
export default {
  name: 'Layout',
  components: { StaticPageLink, Popper },
  methods: {
    toggleNavigation: () => {
      document.getElementById("nav-content").classList.toggle("hidden");
      document.getElementById("nav-toggler").classList.toggle("active");
    }
  },
  mounted() {
    setTimeout(() => {
      this.asideAnimation.value = false;
    }, 500);
  }
}
</script>
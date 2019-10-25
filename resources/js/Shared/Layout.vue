<template>
  <main>
    <nav>
      <div class="container mx-auto py-2">
        <div class="flex flex-row items-center">
          <!-- Left -->
          <inertia-link class="nav-link" :href="route('discussions.index')">
            <img src="/img/4sucres_sidebar.png" alt="Logo 4sucres.org" class="w-10 mr-3">
          </inertia-link>
          <inertia-link :href="route('home')" class="nav-link" :class="{ active: route().current('home') }">Accueil</inertia-link>
          <inertia-link :href="route('discussions.index')" class="nav-link" :class="{ active: route().current('discussions*') }">Forum</inertia-link>

          <span v-for="static_page in $page.app.static_pages.filter(page => page.position == 1)" v-bind:key="static_page.slug">
            <StaticPageLink :static_page="static_page" class='nav-link'></StaticPageLink>
          </span>

          <inertia-link :href="route('search')" class="nav-link push" :class="{ active: route().current('search.query') }">Recherche</inertia-link>

          <!-- Right -->
          <template v-if="$page.auth.user">
            <popper
              trigger="click"
              :options="{ placement: 'left-end', modifiers: {preventOverflow :{ boundariesElement: 'window'  }}}">
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
                <div class="p-4 text-center" v-else>
                  <img src="/svg/sucre_sad.svg" class="mx-auto h-24 mb-4">
                  Aucune notification
                </div>
              </div>
              <button class="nav-link" slot="reference">
                <i class="fas fa-bell"></i>
                <span v-if="$page.auth.user.notifications.length" class="absolute badge badge-danger" style="bottom: .25rem; right: .75rem;">{{ $page.auth.user.notifications.length }}</span>
              </button>
            </popper>

            <inertia-link :href="route('home')" class="nav-link">
              <i class="fas fa-envelope"></i>
              <span v-if="$page.auth.user.private_unread_count" class="absolute badge badge-primary" style="bottom: .25rem; right: .75rem;">{{ $page.auth.user.private_unread_count }}</span>
            </inertia-link>

            <button class="nav-link">
              <i class="fas fa-lightbulb"></i>
            </button>

            <inertia-link
              v-if="$page.auth.user.roles.includes('admin') || $page.auth.user.roles.includes('moderator')"
              :href="route('admin.index')"
              class="nav-link"
              :class="{ active: route().current('admin.index') }">
              <i class="fas fa-lock"></i>
            </inertia-link>

            <div class="nav-link wh-10">
              <popper
                trigger="click"
                :options="{ placement: 'left-end' }">
                <div class="popper">
                  <ul>
                    <li><inertia-link :href="route('users.me')">Profil</inertia-link></li>
                    <li><inertia-link :href="route('user.settings.profile')">Paramètres</inertia-link></li>
                    <li><inertia-link :href="route('logout')" method="post">Déconnexion</inertia-link></li>
                  </ul>
                  <div class="flex items-center px-4 py-4 bg-accent">
                    <img :src="$page.auth.user.avatar_url" :alt="'Avatar de ' + $page.auth.user.name" class="rounded wh-8 shadow">
                    <div class="ml-2 flex-1" style="line-height: 1.1em;">
                      <span class="font-bold">{{ $page.auth.user.display_name }}</span><br>
                      <span class="text-xs text-muted">{{ $page.auth.user.email }}</span>
                    </div>
                  </div>
                </div>
                <button slot="reference">
                  <img :src="$page.auth.user.avatar_url" :alt="'Avatar de ' + $page.auth.user.name" class="wh-10 rounded">
                </button>
              </popper>
            </div>
          </template>
          <template v-else>
            <inertia-link class="nav-link" :href="route('register')" :class="{ active: route().current('register') }">Inscription</inertia-link>
            <inertia-link class="nav-link" :href="route('login')" :class="{ active: route().current('login') }">Connexion</inertia-link>
          </template>
        </div>
      </div>
    </nav>

    <slot/>

    <footer>
      <div class="container mx-auto">
        <div class="mx-auto">
          <img src="/img/4sucres_alt_glitched.png" width="70px" class="inline"> {{ $page.app.version }} &copy; 2019-2020<br><br>
        </div>

        <strong>{{ $page.app.name }}</strong>, parce qu'à 2 on était pas assez.<br>
        Temps d'exécution : <span :title="$page.app.real_runtime + 's'">{{ $page.app.runtime }}s</span><br>

        <span v-for="(static_page) in footer_pages = $page.app.static_pages.filter(page => page.position == 3)" v-bind:key="static_page.slug">
          <StaticPageLink :static_page="static_page"></StaticPageLink>&nbsp;
        </span>
        <!-- <span class="mx-1">—</span> -->
      </div>
    </footer>
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
    mounted() {}
  }
</script>
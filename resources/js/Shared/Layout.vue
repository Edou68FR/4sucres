<template>
  <main>
    <aside :class="{'animated slideInLeft faster': asideAnimation.value}" class="flex flex-col">
      <div class="flex-start flex-grow">
        <div class="aside-brand">
          <inertia-link :href="route('discussions.index')">
            <img src="/img/4sucres_alt_glitched.png" alt="Logo 4sucres.org" class="mx-auto h-6">
          </inertia-link>
        </div>
        <ul class="aside-nav">
          <li><inertia-link :href="route('home')" :class="{ active: route().current('home') }"><i class="fas fa-home"></i></inertia-link></li>
          <li><inertia-link :href="route('discussions.index')" :class="{ active: route().current('discussions*') }"><i class="fas fa-folder"></i></inertia-link></li>
          <li><inertia-link :href="route('search.query')" :class="{ active: route().current('search.query') }"><i class="fas fa-search"></i></inertia-link></li>
        </ul>
      </div>
      <div class="flex-end">
        <ul class="aside-nav">
          <template v-if="$page.auth.user">
            <li><inertia-link :href="route('home')" :class="{ active: route().current('notifications') }"><i class="fas fa-bell"></i></inertia-link></li>
            <li><inertia-link :href="route('home')"><i class="fas fa-envelope"></i></inertia-link></li>
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
                <div class="p-4">
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
                      <img :src="$page.auth.user.avatar_url" :alt="'Avatar de ' + $page.auth.user.name" class="rounded wh-8 shadow-lg">
                      <div class="ml-2 flex-1">
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

    <div class="container mx-auto p-6">
      <slot />
    </div>
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
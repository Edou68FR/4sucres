<template>
  <main>
    <header>
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between">
          <inertia-link :href="route('home')"><img src="/img/4sucres_white.png" class="h-6" /></inertia-link>
          <div class="ml-auto">
              <template v-if="$page.auth.user">
                <div class="nav-fa-stack fa-stack">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fas fa-bell fa-stack-1x fa-sm"></i>
                </div>

                <div class="nav-fa-stack fa-stack">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fas fa-lightbulb fa-stack-1x fa-sm"></i>
                </div>

                <inertia-link v-if="$page.auth.user.roles.includes('admin') || $page.auth.user.roles.includes('moderator')" :href="route('admin.index')">
                  <div class="nav-fa-stack fa-stack" :class="{ active: route().current('admin.index') }">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-lock fa-stack-1x fa-sm"></i>
                  </div>
                </inertia-link>
              </template>

              <div class="inline-block md:hidden nav-fa-stack fa-stack" v-on:click="toggleNavigation()" id="nav-toggler">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fas fa-bars fa-stack-1x fa-sm"></i>
              </div>
          </div>
        </div>
      </div>
    </header>

    <nav class="hidden md:block" id="nav-content">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center">
            <inertia-link :href="route('home')" class="mx-2 nav-link w-full md:w-auto" :class="{ active: route().current('home') }">Accueil</inertia-link>
            <inertia-link :href="route('discussions.index')" class="mx-2 nav-link w-full md:w-auto" :class="{ active: route().current('discussions*') }">Discussions</inertia-link>
            <inertia-link :href="route('search.query')" class="mx-2 nav-link w-full md:w-auto" :class="{ active: route().current('search.query') }">Recherche</inertia-link>
            <span v-for="static_page in $page.app.static_pages.filter(page => page.position == 1)" v-bind:key="static_page.slug">
              <StaticPageLink :static_page="static_page" class='mx-2 nav-link w-full md:w-auto'></StaticPageLink>
            </span>

            <inertia-link v-if="$page.auth.user" :href="route('users.me')" class="mx-2 md:ml-auto nav-link w-full md:w-auto" :class="{ active: route().current('users.me') }">{{ $page.auth.user.display_name }}</inertia-link>
            <inertia-link v-if="$page.auth.user" :href="route('logout')" class="mx-2 nav-link w-full md:w-auto" method="post">Déconnexion</inertia-link>

            <inertia-link v-if="!$page.auth.user" :href="route('register')" class="mx-2 md:ml-auto nav-link w-full md:w-auto" :class="{ active: route().current('register') }">Inscription</inertia-link>
            <inertia-link v-if="!$page.auth.user" :href="route('login')" class="mx-2 nav-link w-full md:w-auto" :class="{ active: route().current('login') }">Connexion</inertia-link>
        </div>
      </div>
    </nav>

    <div class="container mx-auto p-4 md:py-6">
      <slot />
    </div>

    <footer class="container text-muted mx-auto px-4 mb-6">
        <img src="/img/4sucres_alt_glitched.png" class="mx-auto h-6">
        {{ $page.app.name }} {{ $page.app.version }} &copy; 2019<br>
        <br>
        Temps d'exécution : <span :title="$page.app.real_runtime + 's'">{{ $page.app.runtime }}s</span><br>
        <span v-for="(static_page, key) in footer_pages = $page.app.static_pages.filter(page => page.position == 3)" v-bind:key="static_page.slug">
          <StaticPageLink :static_page="static_page"></StaticPageLink>
          <span v-if="key != footer_pages.length - 1" class="mx-1">&mdash;</span>
        </span>

    </footer>
  </main>
</template>

<script>
import StaticPageLink from '@/Shared/Components/StaticPageLink';

export default {
  components: { StaticPageLink },
  methods: {
    toggleNavigation: () => {
      document.getElementById("nav-content").classList.toggle("hidden");
      document.getElementById("nav-toggler").classList.toggle("active");
    }
  }
}
</script>
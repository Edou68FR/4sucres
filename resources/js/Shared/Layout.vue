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

                <inertia-link :href="route('profile')" class="mx-2 nav-link" :class="{ active: route().current('profile') }">
                  <img :src="$page.auth.user.avatar_link" :alt="'Avatar de' + $page.auth.user.display_name" class="wh-6 inline rounded mr-1">
                  {{ $page.auth.user.display_name }}
                </inertia-link>
                <inertia-link :href="route('logout')" class="mx-2 nav-link" method="post"><i class="fas fa-power-off mr-1"></i> Déconnexion</inertia-link>
              </template>
              <template v-else>
                <inertia-link :href="route('register')" class="mx-2 nav-link" :class="{ active: route().current('register') }"><i class="fas fa-user-plus mr-1"></i> Inscription</inertia-link>
                <inertia-link :href="route('login')" class="mx-2 nav-link" :class="{ active: route().current('login') }"><i class="fas fa-power-off mr-1"></i> Connexion</inertia-link>
              </template>
          </div>
        </div>
      </div>
    </header>

    <nav>
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center">
          <inertia-link :href="route('home')" class="mx-2 nav-link flex-none" :class="{ active: route().current('home') }">Accueil</inertia-link>
          <inertia-link :href="route('search.query')" class="mx-2 nav-link flex-none" :class="{ active: route().current('search.query') }">Recherche</inertia-link>
          <inertia-link :href="route('private_discussions.index')" class="mx-2 nav-link flex-none" :class="{ active: route().current('private_discussions.index') }">Messagerie</inertia-link>
          <a href="https://vocabank.org" class="mx-2 nav-link flex-none" target="_blank">VocaBank</a>
        </div>
      </div>
    </nav>

    <div class="container mx-auto px-4 my-6">
      <slot />
    </div>
    <footer class="container text-muted mx-auto px-4 mb-6">
        <img src="/img/4sucres_alt_glitched.png" class="mx-auto h-6">
        4sucres.org {{ $page.app.version }} &copy; 2019<br>
        <br>
        {{ $page.app.presence }} membres actifs <span class="mx-1">&mdash;</span> Temps d'exécution : <span :title="$page.app.real_runtime + 's'">{{ $page.app.runtime }}s</span><br>
        <a :href="route('terms')">Conditions générales d'utilisation</a> <span class="mx-1">&mdash;</span>
        <a :href="route('charter')">Charte d'utilisation</a> <span class="mx-1">&mdash;</span>
        <a href="https://vocabank.org" target="_blank">VocaBank</a><span class="mx-1">&mdash;</span>
        <a href="https://github.com/4sucres/board" target="_blank">GitHub</a>
    </footer>
  </main>
</template>
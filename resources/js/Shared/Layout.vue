<template>
  <main>
    <nav id="header">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center justify-between mb-2">
          <inertia-link :href="route('home')"><img src="/img/4sucres_white.png" class="h-6" /></inertia-link>
        </div>
        <div class="flex flex-wrap items-center">
          <inertia-link :href="route('home')" class="mx-2 nav-link flex-none" :class="{ active: route().current('home') }">Accueil</inertia-link>
          <a href="#" class="mx-2 nav-link flex-none">Statistiques</a>
          <a href="#" class="mx-2 nav-link flex-none">Messagerie</a>
          <a href="#" class="mx-2 nav-link flex-none">Extensions</a>
          <a href="#" class="mx-2 nav-link flex-none">Tribunal</a>
          <a href="https://vocabank.org" class="mx-2 nav-link flex-none" target="_blank">VocaBank</a>
          <a :href="route('home') + '?legacy=true'" class="mx-2 nav-link flex-none">Retour sur la v1</a>
        </div>
      </div>
    </nav>
    <div class="container mx-auto px-4 mb-6">
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
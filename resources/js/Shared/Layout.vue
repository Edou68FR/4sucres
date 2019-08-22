<template>
  <main>
    <header>
      <nav class="navbar navbar-expand-lg shadow">
        <img src="/img/4sucres_white.png" height="30px" />
        <div class="ml-auto">
          <inertia-link href="/" class="text-white">Home</inertia-link>
          <inertia-link href="/inertia" class="text-white">Inertia</inertia-link>
          <a href="/d/p" class="text-white">Retour sur 4sucres</a>
        </div>
      </nav>
    </header>

    <div class="p-4">
      <slot />
    </div>
  </main>
</template>
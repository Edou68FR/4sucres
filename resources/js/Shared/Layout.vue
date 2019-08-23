<template>
  <main>
    <nav id="header">
      <div class="container">
        <div class="mx-auto mb-2 flex flex-wrap items-center justify-between">
          <div class="mx-4">
            <a href="https://vocabank-4sucres.localhost/home">
              <img src="/img/4sucres_white.png" class="h-6" />
            </a>
          </div>
          <!-- <div class="w-auto mx-2 ml-auto pt-4 pt-0" id="nav-content">
            <ul class="flex flex-wrap items-center justify-center md:justify-end">
              <li class="w-full mx-2 mb-4 md:hidden">
                <form
                  action="https://vocabank-4sucres.localhost/samples/search"
                  method="get"
                  class="flex"
                >
                  <div class="flex-auto mr-4">
                    <input
                      type="text"
                      placeholder="Recherche"
                      class="form-control form-control-inverse w-full"
                      name="q"
                      value
                    />
                  </div>
                  <button type="submit">
                    <i class="nav-link fa fa-fw fa-search"></i>
                  </button>
                </form>
              </li>
              <li class="mx-2 my-2 md:my-0">
                <a href="https://vocabank-4sucres.localhost/register" class="nav-link">Inscription</a>
              </li>
              <li class="mx-2 my-2 md:my-0">
                <a href="https://vocabank-4sucres.localhost/login" class="nav-link">Connexion</a>
              </li>
            </ul>
          </div>-->
        </div>
        <div class="mx-auto pl-2 flex flex-wrap items-center">
          <inertia-link :href="route('home')" class="mx-2">Accueil</inertia-link>
          <inertia-link href="/inertia" class="mx-2">Inertia</inertia-link>
          <a href="/d/p" class="mx-2">Retour sur 4sucres</a>
        </div>
      </div>
    </nav>
    <div class="mx-4 mb-6">
      <slot />
    </div>
  </main>
</template>
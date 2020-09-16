<template>
  <div class="header">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
      <!-- Brand -->
      <a class="navbar-brand" href="#">Logo</a>

      <!-- Links -->
      <ul class="navbar-nav">
        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbardrop"
            data-toggle="dropdown"
          >Factures</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'factures' }">
                <a class="dropdown-item" href="#">Factures</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'facturesList' }">
                <a class="dropdown-item" href="#">Factures</a>
              </router-link>
            </a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbardrop"
            data-toggle="dropdown"
          >Clients</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'clients' }">
                <a class="dropdown-item" href="#">Clients</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'clientsList' }">
                <a class="dropdown-item" href="#">Client list</a>
              </router-link>
            </a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbardrop"
            data-toggle="dropdown"
          >Navires</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'navires' }">
                <a class="dropdown-item" href="#">Navires</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'naviresList' }">
                <a class="dropdown-item" href="#">Navire list</a>
              </router-link>
            </a>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbardrop"
            data-toggle="dropdown"
          >Gerants</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'gerants' }">
                <a class="dropdown-item" href="#">Gerants</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'gerantsList' }">
                <a class="dropdown-item" href="#">Gerant list</a>
              </router-link>
            </a>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</template>

<style scoped>
li {
  margin-right: 20px;
}
</style>

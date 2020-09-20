<template>
  <div class="header">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark logo">
      <!-- Brand -->
      <a class="navbar-brand logo" href="#">
        <img src="@/images//logo.png" alt="Yellowrock logo" height="80px;" width="200px;" />
      </a>

      <!-- Links -->
      <ul class="navbar-nav">
        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbardrop"
            data-toggle="dropdown"
            style="margin-left: 50px;"
          >Factures</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'factures' }">
                <a class="dropdown-item" href="#">Factures</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'facturesList' }">
                <a class="dropdown-item" href="#">Facture list</a>
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
.logo {
  padding: 0px;
  background-color: white;
  padding: 0px;
  margin: 0px;
}
</style>

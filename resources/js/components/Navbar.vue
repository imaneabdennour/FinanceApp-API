<template>
  <div class="header">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark logo">
      <!-- Brand -->
      <a class="navbar-brand logo" href="#">
        <img
          :src="'/images/logo.png'"
          alt="Yellowrock logo"
          height="80px;"
          width="200px;"
        />
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
            style="margin-left: 50px"
            >Factures</a
          >
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'factures' }">
                <a class="dropdown-item" href="#">Ajouter une facture</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'facturesList' }">
                <a class="dropdown-item" href="#">Liste de factures</a>
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
            >Clients</a
          >
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'clients' }">
                <a class="dropdown-item" href="#">Ajouter un client</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'clientsList' }">
                <a class="dropdown-item" href="#">Liste de clients</a>
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
            >Navires</a
          >
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'navires' }">
                <a class="dropdown-item" href="#">Ajouter un navire</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'naviresList' }">
                <a class="dropdown-item" href="#">Liste de navires</a>
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
            >Contacts</a
          >
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'contacts' }">
                <a class="dropdown-item" href="#">Ajouter un contact</a>
              </router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'contactsList' }">
                <a class="dropdown-item" href="#">Liste des contacts</a>
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

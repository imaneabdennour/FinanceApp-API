<template>
  <div class="header">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
      <div class="dropdown show">
        <a
          class="btn btn-secondary dropdown-toggle"
          href="#"
          role="button"
          id="dropdownMenuLink"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >Factures</a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <router-link :to="{ name: 'factures' }">
            <a class="dropdown-item" href="#">Factures</a>
          </router-link>
          <router-link :to="{ name: 'facturesList' }">
            <a class="dropdown-item" href="#">List factures</a>
          </router-link>
        </div>
      </div>
      <div class="dropdown show">
        <a
          class="btn btn-secondary dropdown-toggle"
          href="#"
          role="button"
          id="dropdownMenuLink"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >Clients</a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <router-link :to="{ name: 'clients' }">
            <a class="dropdown-item" href="#">Client</a>
          </router-link>
          <router-link :to="{ name: 'clientsList' }">
            <a class="dropdown-item" href="#">List clients</a>
          </router-link>
        </div>
      </div>

      <div class="dropdown show">
        <a
          class="btn btn-secondary dropdown-toggle"
          href="#"
          role="button"
          id="dropdownMenuLink"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >Navires</a>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <router-link :to="{ name: 'navires' }">
            <a class="dropdown-item" href="#">Navires</a>
          </router-link>
          <router-link :to="{ name: 'naviresList' }">
            <a class="dropdown-item" href="#">List navires</a>
          </router-link>
        </div>

        <div class="dropdown show">
          <a
            class="btn btn-secondary dropdown-toggle"
            href="#"
            role="button"
            id="dropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >Gerants</a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <router-link :to="{ name: 'gerants' }">
              <a class="dropdown-item" href="#">Gerants</a>
            </router-link>
            <router-link :to="{ name: 'gerantsList' }">
              <a class="dropdown-item" href="#">List gerants</a>
            </router-link>
          </div>
        </div>

        <div class="dropdown show">
          <a
            class="btn btn-secondary dropdown-toggle"
            href="#"
            role="button"
            id="dropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >Form test</a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <router-link :to="{ name: 'form' }">
              <a class="dropdown-item" href="#">Form</a>
            </router-link>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

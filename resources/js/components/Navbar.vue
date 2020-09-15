<template>
  <div class="header">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
      <ul id="nav">
        <router-link :to="{ name: 'test' }">Test</router-link>
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
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'factures' }">Factures</router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'facturesList' }">List factures</router-link>
            </a>
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
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'clients' }">Client</router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'clientsList' }">List clients</router-link>
            </a>
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
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'navires' }">Navires</router-link>
            </a>
            <a class="dropdown-item" href="#">
              <router-link :to="{ name: 'naviresList' }">List navires</router-link>
            </a>
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
              <a class="dropdown-item" href="#">
                <router-link :to="{ name: 'gerants' }">Gerants</router-link>
              </a>
              <a class="dropdown-item" href="#">
                <router-link :to="{ name: 'gerantsList' }">List gerants</router-link>
              </a>
            </div>
          </div>
        </div>
      </ul>
    </nav>
  </div>
</template>

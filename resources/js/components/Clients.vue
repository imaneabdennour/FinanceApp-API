<template>
  <div>
    <h2>Clients</h2>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" v-bind:class="[{ disabled: !pagination.prev_page_url }]">
          <a class="page-link" href="#" @click="fetchClients(pagination.prev_page_url)">Previous</a>
        </li>

        <li class="page-item disabled">
          <a
            href="#"
            class="page-link text-dark"
          >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
        </li>

        <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page_url }]">
          <a class="page-link" href="#" @click="fetchClients(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>

    <div class="card card-body" v-for="client in clients" :key="client.nom_entreprise">
      <h3>{{ client.nom_entreprise }}</h3>
      <p>{{ client.adresse }} | {{ client.ville }}</p>
      <p>{{ client.category }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      clients: [],
      client: {
        nom_entreprise: "",
        adresse: "",
        ville: "",
        num_compte_bancaire: "",
        RC: "",
        ICE: "",
      },
      client_id: "",
      pagination: {},
      edit: false, //same form to add and edit
    };
  },
  created() {
    //fetch clients :
    this.fetchClients();
  },
  methods: {
    fetchClients(page_url) {
      //depends on pagination
      let vm = this;
      page_url = page_url || "/api/clients";
      fetch(page_url)
        .then((res) => res.json()) //formate the data to json format
        .then((res) => {
          //res is an object
          this.clients = res.data;
          vm.makePagination(res.meta, res.links); //for pagination purposes
        })
        .catch((err) => console.log("error fetching clients"));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
      };
      this.pagination = pagination;
      /*
            Exemple :
                "links": {
                    "first": "http://127.0.0.1:8000/api/clients?page=1",
                    "last": "http://127.0.0.1:8000/api/clients?page=1",
                    "prev": null,
                    "next": null
                },
                "meta": {
                    "current_page": 1,
                    "from": 1,
                    "last_page": 1,
                    "path": "http://127.0.0.1:8000/api/clients",
                    "per_page": 5,
                    "to": 2,
                    "total": 2
                }
            */
    },
  },
};
</script>

<template>
  <div>
    <div class="container-lg">
      <div class="table-responsive">
        <div class="table-wrapper">
          <div class="table-title">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item" v-bind:class="[{ disabled: !pagination.prev_page_url }]">
                  <a
                    class="page-link"
                    href="#"
                    @click="fetchFactures(pagination.prev_page_url)"
                  >Previous</a>
                </li>

                <li class="page-item disabled">
                  <a href="#" class="page-link text-dark">
                    Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                  </a>
                </li>

                <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page_url }]">
                  <a
                    class="page-link"
                    href="#"
                    @click="fetchFactures(pagination.next_page_url)"
                  >Next</a>
                </li>
              </ul>
            </nav>
            <div class="row">
              <div class="col-sm-8">
                <h2>
                  Employee
                  <b>Details</b>
                </h2>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-info add-new">
                  <i class="fa fa-plus"></i>
                  <router-link :to="{ name: 'factures' }">Add New</router-link>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Client</th>
                <th>Proforma</th>
                <th>Num de facture</th>
                <th>Num de commande</th>
                <th>Condition</th>
                <th>Navire</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Nature</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="fac in factures" v-bind:key="fac.num_commande">
                <td>{{fac.client}}</td>
                <td>{{fac.proforma}}</td>
                <td>{{fac.num_facture}}</td>
                <td>{{fac.num_commande}}</td>
                <td>{{fac.condition}}</td>
                <td>{{fac.navire}}</td>
                <td>{{fac.statut}}</td>
                <td>{{fac.date}}</td>
                <td>{{fac.nature}}</td>

                <td>
                  <a class="add" title="Add" data-toggle="tooltip">
                    <i class="material-icons">&#xE03B;</i>
                  </a>
                  <a class="edit" title="Edit" data-toggle="tooltip">
                    <i class="material-icons">&#xE254;</i>
                  </a>
                  <a
                    class="delete"
                    title="Delete"
                    data-toggle="tooltip"
                    @click="deleteFacture(facture.num_commande)"
                  >
                    <i class="material-icons">&#xE872;</i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      factures: [],
      facture: {
        num_commande: "",
        num_facture: "",
        client: "",
        proforma: "",
        condition: "",
        navire: "",
        statut: "",
        date: "",
        nature: ""
      },
      entreprises: [],
      conditions: [
        "Chèque à 10 jrs",
        "Effet à 60 jrs",
        "Réglé sur base proforma"
      ],
      naviresActif: [],
      natures: ["Marge de transformation", "Fraix d'extension", "Transport"],
      pagination: {},
      edit: false //same form to add and edit => if edit : we're going to update so edit = true
    };
  },
  created() {
    this.fetchFactures();
    this.fetchEntreprises();
    this.fetchNavires();
  },
  methods: {
    fetchFactures(page_url) {
      //depends on pagination
      let vm = this;
      page_url = page_url || "/api/factures";
      fetch(page_url)
        .then(res => res.json()) //formate the data to json format
        .then(res => {
          //res is an object
          this.factures = res.data;
          vm.makePagination(res.meta, res.links); //for pagination purposes
        })
        .catch(err => console.log("error fetching factures"));
    },
    fetchEntreprises() {
      fetch("/api/clients")
        .then(res => res.json()) //formate the data to json format
        .then(res => {
          this.index = res.meta.last_page;
          this.entreprises = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/clients?page=" + i)
                .then(res => res.json()) //formate the data to json format
                .then(res => {
                  //res is an object
                  this.entreprises = this.entreprises.concat(res.data);
                });
            }
          }
        });
    },
    fetchNavires() {
      fetch("/api/navires")
        .then(res => res.json())
        .then(res => {
          this.index = res.meta.last_page;
          this.naviresActif = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/navires?page=" + i)
                .then(res => res.json())
                .then(res => {
                  this.naviresActif = this.naviresActif.concat(res.data);
                });
            }
          }
        })
        .catch(err => console.log(err));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    deleteFacture(num_commande) {
      //make delete request to our api
      if (confirm("Are you sure ? ")) {
        fetch("api/facture/" + num_commande, {
          method: "delete"
        })
          .then(res => res.json()) //formate the data to json format
          .then(data => {
            //data is an object
            alert("Facture deleted");
            this.fetchFactures();
          })
          .catch(err => console.log(err));
      }
    },
    editFacture(facture) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.client.nom_entreprise = client.nom_entreprise;
      //  this.client.id = client.nom_entreprise;
      this.facture.num_commande = facture.num_commande;
      this.facture.num_facture = facture.num_facture;
      this.facture.client = facture.client;
      this.facture.proforma = facture.proforma;
      this.facture.condition = facture.condition;
      this.facture.navire = facture.navire;
      this.facture.statut = facture.statut;
      this.facture.date = facture.date;
      this.facture.nature = facture.nature;
    }
  }
};
</script>


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
                    @click="fetchClients(pagination.prev_page_url)"
                  >Previous</a>
                </li>

                <li class="page-item disabled">
                  <a href="#" class="page-link text-dark">
                    Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                  </a>
                </li>

                <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page_url }]">
                  <a class="page-link" href="#" @click="fetchClients(pagination.next_page_url)">Next</a>
                </li>
              </ul>
            </nav>
            <div class="row">
              <div class="col-sm-8">
                <h2>
                  Clients
                  <b>Details</b>
                </h2>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-info add-new">
                  <i class="fa fa-plus"></i>
                  <router-link :to="{ name: 'clients' }">Add New</router-link>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nom entreprise</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th style="width: 170px;">Num compte bancaire</th>
                <th>RC</th>
                <th>ICE</th>
                <th>Catégorie</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="client in clients" :key="client.nom_entreprise">
                <td>{{client.nom_entreprise}}</td>
                <td>{{client.adresse}}</td>
                <td>{{client.ville}}</td>
                <td>{{client.num_compte_bancaire}}</td>
                <td>{{client.RC}}</td>
                <td>{{client.ICE}}</td>
                <td>{{client.category}}</td>
                <td>
                  <a class="add" title="Add" data-toggle="tooltip">
                    <i class="material-icons">&#xE03B;</i>
                  </a>
                  <a
                    class="edit"
                    title="Edit"
                    data-toggle="tooltip"
                    @click="editClient(client); openModel(); "
                  >
                    <i class="material-icons">&#xE254;</i>
                  </a>
                  <a
                    class="delete"
                    title="Delete"
                    data-toggle="tooltip"
                    @click="deleteClient(client.nom_entreprise)"
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

    <div v-if="myModel">
      <transition name="model">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                  <div>
                    <form @submit.prevent="addClient" method="post" class="mb-4">
                      <button type="button" class="close" @click="myModel=false">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Nom de l'entreprise"
                          v-model="client.nom_entreprise"
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Adresse"
                          v-model="client.adresse"
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Ville"
                          v-model="client.ville"
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Num de compte bancaire"
                          v-model="client.num_compte_bancaire"
                          maxlength="16"
                          minlength="16"
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="RC"
                          v-model="client.RC"
                        />
                      </div>
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="ICE"
                          v-model="client.ICE"
                        />
                      </div>
                      <div class="form-group">
                        <select name="category" v-model="client.category" class="form-control">
                          <option disabled value>Category</option>
                          <option v-for="cat in categories" v-bind:key="cat">
                            {{
                            cat
                            }}
                          </option>
                        </select>
                      </div>

                      <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        style=" width: 20%; margin: auto;"
                      >Save</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      clients: [],
      client: {
        id: "",
        nom_entreprise: "",
        adresse: "",
        ville: "",
        num_compte_bancaire: "",
        RC: "",
        ICE: "",
        category: "",
      },
      categories: ["Fournisseur", "Client"],
      pagination: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true

      myModel: false,
    };
  },
  created() {
    //fetch clients :
    this.fetchClients();
  },
  methods: {
    addClient() {
      //Update
      fetch("api/client", {
        method: "PUT",
        body: JSON.stringify(this.client),
        headers: {
          "content-type": "application/json",
        },
      })
        .then((res) => res.json())
        .then((data) => {
          //we wanna clear the form : empty it bcz it's binded with the inputs
          this.client.nom_entreprise = "";
          this.client.adresse = "";
          this.client.ville = "";
          this.client.num_compte_bancaire = "";
          this.client.RC = "";
          this.client.ICE = "";
          this.client.category = "";

          alert("Client updated");
          this.fetchClients();
          this.myModel = false;
        })
        .catch((err) => console.log(err));
    },
    openModel() {
      this.myModel = true;
    },
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
    deleteClient(nom_entreprise) {
      //make delete request to our api
      if (confirm("Are you sure ? ")) {
        fetch("api/client/" + nom_entreprise, {
          method: "delete",
        })
          .then((res) => res.json()) //formate the data to json format
          .then((data) => {
            //data is an object
            alert("Client deleted");
            this.fetchClients();
          })
          .catch((err) => console.log(err));
      }
    },
    editClient(client) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.client.nom_entreprise = client.nom_entreprise;
      //  this.client.id = client.nom_entreprise;
      this.client.adresse = client.adresse;
      this.client.ville = client.ville;
      this.client.num_compte_bancaire = client.num_compte_bancaire;
      this.client.RC = client.RC;
      this.client.ICE = client.ICE;
      this.client.category = client.category;
    },
  },
};
</script>


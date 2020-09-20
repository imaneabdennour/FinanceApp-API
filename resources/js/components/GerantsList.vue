<template>
  <!--start-->
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
                    @click="fetchGerants(pagination.prev_page_url)"
                  >Previous</a>
                </li>

                <li class="page-item disabled">
                  <a href="#" class="page-link text-dark">
                    Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                  </a>
                </li>

                <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page_url }]">
                  <a class="page-link" href="#" @click="fetchGerants(pagination.next_page_url)">Next</a>
                </li>
              </ul>
            </nav>
            <div class="row">
              <div class="col-sm-8">
                <h2>
                  Gerants
                  <b>Details</b>
                </h2>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-info add-new">
                  <i class="fa fa-plus"></i>
                  <router-link :to="{ name: 'gerants' }">Add New</router-link>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Civilité</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Num telef</th>
                <th>Entreprise</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="gerant in gerants" :key="gerant.id">
                <td>{{gerant.civilité}}</td>
                <td>{{gerant.nom_complet}}</td>
                <td>{{gerant.email}}</td>
                <td>{{gerant.telef}}</td>
                <td>{{gerant.entreprise}}</td>
                <td>
                  <a class="add" title="Add" data-toggle="tooltip">
                    <i class="material-icons">&#xE03B;</i>
                  </a>
                  <a
                    class="edit"
                    title="Edit"
                    data-toggle="tooltip"
                    @click="editGerant(gerant); openModel(); "
                    value="Add"
                  >
                    <i class="material-icons">&#xE254;</i>
                    <!--<button @click="editGerant(gerant)" class="btn btn-warning">Edit</button>
                    -->
                  </a>
                  <a
                    class="delete"
                    title="Delete"
                    data-toggle="tooltip"
                    @click="deleteGerant(gerant.id)"
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
                    <form @submit.prevent="addGerant" method="post" class="mb-3">
                      <button type="button" class="close" @click="myModel=false">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="form-group">
                        <label for="civilité" style="margin-right:100px;">Civilité :</label>
                        <input type="radio" name="civilité" value="Mdm" v-model="gerant.civilité" />
                        <span style="margin-right:20px;">Mdm</span>

                        <input type="radio" name="civilité" value="Mr" v-model="gerant.civilité" />
                        <span>Mr</span>
                      </div>

                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Nom complet"
                          v-model="gerant.nom_complet"
                        />
                      </div>

                      <div class="form-group">
                        <input
                          type="email"
                          class="form-control"
                          placeholder="Email"
                          v-model="gerant.email"
                        />
                      </div>

                      <div class="form-group">
                        <vue-tel-input
                          validCharactersOnly="true"
                          placeholder="Entrer un num de telef"
                          class="form-control"
                          @input="onInput"
                        ></vue-tel-input>
                      </div>

                      <div class="form-group">
                        <select name="category" v-model="gerant.entreprise" class="form-control">
                          <option disabled value>Entreprise</option>
                          <option
                            v-for="entr in entreprises"
                            v-bind:key="entr.nom_entreprise"
                          >{{ entr.nom_entreprise }}</option>
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
  <!--finish-->
</template>

<script>
export default {
  data() {
    return {
      gerants: [],
      gerant: {
        id: "",
        civilité: "",
        nom_complet: "",
        email: "",
        telef: "",
        entreprise: "",
      },
      entreprises: [],
      pagination: {},
      paginationClient: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
      index: 0,

      myModel: false,
    };
  },
  created() {
    //fetch gerants :
    this.fetchGerants();
    this.fetchEntreprises();
  },
  methods: {
    fetchEntreprises() {
      fetch("/api/clients")
        .then((res) => res.json()) //formate the data to json format
        .then((res) => {
          this.index = res.meta.last_page;
          this.entreprises = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/clients?page=" + i)
                .then((res) => res.json()) //formate the data to json format
                .then((res) => {
                  //res is an object
                  this.entreprises = this.entreprises.concat(res.data);
                });
            }
          }
        });
    },
    addGerant() {
      //Update
      fetch("api/gerant", {
        method: "PUT",
        body: JSON.stringify(this.gerant),
        headers: {
          "content-type": "application/json",
        },
      })
        .then((res) => res.json())
        .then((data) => {
          //we wanna clear the form : empty it bcz it's binded with the inputs
          this.gerant.id = "";
          this.gerant.civilité = "";
          this.gerant.nom_complet = "";
          this.gerant.email = "";
          this.gerant.telef = "";
          this.gerant.entreprise = "";

          alert("Gerant updated");
          this.fetchGerants();
          this.myModel = false;
        })
        .catch((err) => console.log(err));
    },
    openModel() {
      this.myModel = true;
    },
    fetchGerants(page_url) {
      //depends on pagination
      let vm = this;
      page_url = page_url || "/api/gerants";
      fetch(page_url)
        .then((res) => res.json()) //formate the data to json format
        .then((res) => {
          //res is an object
          this.gerants = res.data;
          vm.makePagination(res.meta, res.links); //for pagination purposes
        })
        .catch((err) => console.log("error fetching gerants"));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
      };
      this.pagination = pagination;
    },
    deleteGerant(id) {
      //make delete request to our api
      if (confirm("Are you sure ? ")) {
        fetch("api/gerant/" + id, {
          method: "delete",
        })
          .then((res) => res.json()) //formate the data to json format
          .then((data) => {
            //data is an object
            alert("Gerant deleted");
            this.fetchGerants();
          })
          .catch((err) => console.log(err));
      }
    },
    editGerant(gerant) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.gerant.id = gerant.id;
      this.gerant.civilité = gerant.civilité;
      this.gerant.nom_complet = gerant.nom_complet;
      this.gerant.email = gerant.email;
      this.gerant.telef = gerant.telef;
      this.gerant.entreprise = gerant.entreprise;
    },
  },
};
</script>

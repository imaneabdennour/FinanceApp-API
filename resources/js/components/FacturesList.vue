<template>
  <div>
    <div class="container-lg">
      <div class="table-responsive">
        <div class="table-wrapper">
          <div class="table-title">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li
                  class="page-item"
                  v-bind:class="[
                                        { disabled: !pagination.prev_page_url }
                                    ]"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="
                                            fetchFactures(
                                                pagination.prev_page_url
                                            )
                                        "
                  >Previous</a>
                </li>

                <li class="page-item disabled">
                  <a href="#" class="page-link text-dark">
                    Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                  </a>
                </li>

                <li
                  class="page-item"
                  v-bind:class="[
                                        { disabled: !pagination.next_page_url }
                                    ]"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="
                                            fetchFactures(
                                                pagination.next_page_url
                                            )
                                        "
                  >Next</a>
                </li>
              </ul>
            </nav>
            <div class="row">
              <div class="col-sm-8">
                <h2>
                  Facture
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
                <th style="width: 90px;">Proforma</th>
                <th>Type</th>
                <th style="width:130px;">Num de facture</th>
                <th style="width: 95px;">Num de commande</th>
                <th style="width: 90px;">Condition</th>
                <th>Navire</th>
                <th style="width: 70px;">Statut</th>
                <th>Date</th>
                <th>Nature</th>
                <th style="width: 100px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="fac in factures" v-bind:key="fac.num_commande">
                <td>{{ fac.client }}</td>
                <td>{{ fac.proforma }}</td>
                <td>{{fac.type}}</td>
                <td>{{ fac.num_facture }}</td>
                <td>{{ fac.num_commande }}</td>
                <td>{{ fac.condition }}</td>
                <td>{{ fac.navire }}</td>
                <td>{{ fac.statut }}</td>
                <td>{{ fac.date }}</td>
                <td>{{ fac.nature }}</td>

                <td>
                  <a class="add" title="Add" data-toggle="tooltip">
                    <i class="material-icons">&#xE03B;</i>
                  </a>
                  <a
                    class="edit"
                    title="Edit"
                    data-toggle="tooltip"
                    @click="editFacture(fac); openModel(); "
                    value="Add"
                  >
                    <i class="material-icons">&#xE254;</i>
                  </a>
                  <a
                    class="delete"
                    title="Delete"
                    data-toggle="tooltip"
                    @click="
                                            deleteFacture(facture.num_commande)
                                        "
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
                    <form @submit.prevent="addFacture" method="post" class="mb-3">
                      <button type="button" class="close" @click="myModel=false">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="form-group">
                        <select name="category" v-model="facture.client" class="form-control">
                          <option value>-- Entreprise --</option>
                          <option
                            v-for="entr in entreprises"
                            v-bind:key="entr.entreprise"
                          >{{ entr.nom_entreprise }}</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="proforma" style="margin-right:100px;">Proforma</label>
                        <input
                          type="radio"
                          name="proforma"
                          value="Oui"
                          v-model="facture.proforma"
                          @change="CalculNumFacture1"
                        />
                        <span style="margin-right:20px;">Oui</span>

                        <input
                          type="radio"
                          name="proforma"
                          value="Non"
                          v-model="facture.proforma"
                          @change="CalculNumFacture1"
                        />
                        <span>Non</span>
                      </div>

                      <div class="form-group" v-if="facture.proforma == 'Non'">
                        <select
                          name="type"
                          v-model="facture.type"
                          class="form-control"
                          @change="CalculNumFacture2"
                        >
                          <option disabled value>-- Type --</option>
                          <option v-for="type in types" v-bind:key="type">
                            {{
                            type
                            }}
                          </option>
                        </select>
                      </div>

                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Num de facture"
                          v-model="facture.num_facture"
                          disabled
                        />
                      </div>

                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Num de commande"
                          v-model="facture.num_commande"
                          disabled
                        />
                      </div>

                      <div class="form-group">
                        <select name="condition" v-model="facture.condition" class="form-control">
                          <option disabled value>-- Condition --</option>
                          <option v-for="cond in conditions" v-bind:key="cond">
                            {{
                            cond
                            }}
                          </option>
                        </select>
                      </div>

                      <div class="form-group">
                        <select name="navire" v-model="facture.navire" class="form-control">
                          <option disabled value>-- Navire --</option>
                          <option
                            v-for="entr in actifNavires"
                            v-bind:key="entr.nom_navire"
                          >{{ entr.nom_navire }}</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label style="margin-right:100px;">Statut</label>
                        <input type="radio" name="statu" value="Payé" v-model="facture.statut" />
                        <span style="margin-right:20px;">Payé</span>

                        <input type="radio" name="statu" value="Non payé" v-model="facture.statut" />
                        <span>Non payé</span>
                      </div>
                      <div class="form-group">
                        <input
                          type="date"
                          value="dateFormate"
                          class="form-control"
                          v-model="facture.date"
                        />
                      </div>
                      <div class="form-group">
                        <select name="navire" v-model="facture.nature" class="form-control">
                          <option disabled value>-- Nature --</option>
                          <option v-for="nat in natures" v-bind:key="nat">
                            {{
                            nat
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

<style >
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>

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
        nature: "",
      },
      types: ["Initial", "Note de crédit"],
      entreprises: [],
      conditions: [
        "Chèque à 10 jrs",
        "Effet à 60 jrs",
        "Réglé sur base proforma",
      ],
      actifNavires: [],
      navires: [],
      natures: ["Marge de transformation", "Fraix d'extension", "Transport"],
      pagination: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true

      //modal :
      myModel: false,
    };
  },
  created() {
    this.fetchFactures();
    this.fetchEntreprises();
    this.fetchNavires();
    this.fetchFactures();
  },
  methods: {
    openModel() {
      this.myModel = true;
    },
    addFacture() {
      //used for update
      fetch("api/facture", {
        method: "PUT",
        body: JSON.stringify(this.facture),
        headers: {
          "content-type": "application/json",
        },
      })
        .then((res) => res.json())
        .then((data) => {
          //we wanna clear the form : empty it bcz it's binded with the inputs
          this.facture.num_commande = "";
          this.facture.num_facture = "";
          this.facture.client = "";
          this.facture.proforma = "";
          this.facture.condition = "";
          this.facture.navire = "";
          this.facture.statut = "";
          this.facture.date = "";
          this.facture.nature = "";

          alert("Client updated");
          this.fetchFactures();
          this.myModel = false;
        })
        .catch((err) => console.log(err));
    },

    fetchFactures() {
      //depends on pagination
      fetch("/api/factures")
        .then((res) => res.json()) //formate the data to json format
        .then((res) => {
          //res is an object
          this.factures = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/factures?page=" + i)
                .then((res) => res.json())
                .then((res) => {
                  this.factures = this.factures.concat(res.data);
                });
            }
          }
        })
        .catch((err) => console.log("error fetching factures"));
    },
    CalculNumFacture1() {
      let _this = this;

      //based on proForma
      if (this.facture.proforma == "Non") {
        //non
        this.facture.num_facture = "";
      } else if (this.facture.proforma == "Oui") {
        this.facture.num_facture =
          "P" + new Date().getFullYear() + "/" + this.Calcul("P");
      }
    },
    Calcul(debut) {
      var listNbr = []; //list de num d factures (type int) qui va être triée
      for (let index = 0; index < this.factures.length; index++) {
        const prof = this.factures[index].num_facture; //current num d facture of my element
        //si prof = meme debut de la var debut : soit P, F ou bien N
        if (debut.charAt(0) == prof.charAt(0)) {
          if (debut.charAt(0) == "N") {
            listNbr.push(parseInt(prof.slice(7)));
          } else if (debut.charAt(0) == "F") {
            listNbr.push(parseInt(prof.slice(6)));
          } else if (debut.charAt(0) == "P") {
            listNbr.push(parseInt(prof.slice(6)));
          }
        }
      }
      if (listNbr.length == 0) {
        return "000000";
      } else {
        //max of listNbr :
        var max = Math.max.apply(Math, listNbr);

        var nbr = max + 1; //increm
        var nbrString = nbr + ""; //conversion en string
        var stringLength = nbrString.length; //length of nbrString

        var res = "";
        for (let i = 0; i < 6 - stringLength; i++) {
          res = res + "0";
        }
        res = res + nbrString;

        return res;
      }
    },
    CalculNumFacture2() {
      let _this = this;
      //based on type
      if (this.facture.type == "Initial") {
        this.facture.num_facture =
          "F" + new Date().getFullYear() + "/" + _this.Calcul("F");
      } else if (this.facture.type == "Note de crédit") {
        this.facture.num_facture =
          "NC" + new Date().getFullYear() + "/" + _this.Calcul("NC");
      }
    },
    dateFormate() {
      let year = new Date().getFullYear();
      let month = new Date().getUTCMonth() + 1;
      let day = new Date().getDate();

      let z = "0";

      if (month >= 10) {
        z = "";
      }

      this.facture.date = year + "-" + z + month + "-" + day;
    },
    fetchFactures(page_url) {
      //depends on pagination
      let vm = this;
      page_url = page_url || "/api/factures";
      fetch(page_url)
        .then((res) => res.json()) //formate the data to json format
        .then((res) => {
          //res is an object
          this.factures = res.data;
          vm.makePagination(res.meta, res.links); //for pagination purposes
        })
        .catch((err) => console.log("error fetching factures"));
    },
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
    fetchNavires() {
      fetch("/api/navires")
        .then((res) => res.json())
        .then((res) => {
          this.index = res.meta.last_page;
          this.navires = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/navires?page=" + i)
                .then((res) => res.json())
                .then((res) => {
                  this.navires = this.navires.concat(res.data);
                });
            }
          }
          for (let i = 0; i < this.navires.length; i++) {
            //navires qui sont actifs c-à-d statut = 'En cours'
            if (this.navires[i].statut == "En cours") {
              this.actifNavires.push(this.navires[i]);
            }
          }
        })
        .catch((err) => console.log(err));
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
    deleteFacture(num_commande) {
      //make delete request to our api
      if (confirm("Are you sure ? ")) {
        console.log(num_commande);
        fetch("api/facture/" + num_commande, {
          method: "delete",
        })
          .then((res) => res.json()) //formate the data to json format
          .then((data) => {
            //data is an object
            alert("Facture deleted");
            this.fetchFactures();
          })
          .catch((err) => console.log(err));
      }
    },
    editFacture(facture) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.facture.num_commande = facture.num_commande;
      this.facture.num_facture = facture.num_facture;
      this.facture.client = facture.client;
      this.facture.proforma = facture.proforma;
      this.facture.condition = facture.condition;
      this.facture.navire = facture.navire;
      this.facture.statut = facture.statut;
      this.facture.date = facture.date;
      this.facture.nature = facture.nature;
    },
  },
};
</script>

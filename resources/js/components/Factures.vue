<template>
  <div>
    <h2>Factures</h2>

    <form @submit.prevent="addFacture" method="post" class="mb-3">
      <div class="form-group">
        <select name="category" v-model="facture.client">
          <option disabled value>Entreprise</option>
          <option
            v-for="entr in entreprises"
            v-bind:key="entr.nom_entreprise"
          >{{ entr.nom_entreprise }}</option>
        </select>
      </div>

      <div class="form-group">
        <label for="proforma">Proforma</label>
        Oui
        <input type="radio" name="proforma" value="Oui" v-model="facture.proforma" />
        Non
        <input type="radio" name="proforma" value="Non" v-model="facture.proforma" />
      </div>

      <div class="form-group">
        <input
          type="text"
          class="form-control"
          placeholder="Num de facture"
          v-model="facture.num_facture"
        />
      </div>

      <div class="form-group">
        <input
          type="text"
          class="form-control"
          placeholder="Num de commande"
          v-model="facture.num_commande"
        />
      </div>

      <div class="form-group">
        <select name="condition" v-model="facture.condition">
          <option disabled value>Condition</option>
          <option v-for="cond in conditions" v-bind:key="cond">
            {{
            cond
            }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="navire" v-model="facture.navire">
          <option disabled value>Navire</option>
          <option v-for="entr in naviresActif" v-bind:key="entr.nom_navire">{{ entr.nom_navire }}</option>
        </select>
      </div>

      <div class="form-group">
        Payé
        <input type="radio" name="statu" value="Payé" v-model="facture.statut" />
        Non payé
        <input type="radio" name="statu" value="Non payé" v-model="facture.statut" />
      </div>

      <div class="form-group">
        <input type="date" class="form-control" v-model="facture.date" />
      </div>

      <div class="form-group">
        <select name="navire" v-model="facture.nature">
          <option disabled value>Nature</option>
          <option v-for="nat in natures" v-bind:key="nat">
            {{
            nat
            }}
          </option>
        </select>
      </div>

      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
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
    addFacture() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/facture", {
          method: "POST",
          body: JSON.stringify(this.facture),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
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

            alert("Facture added");
            this.fetchFactures();
          })
          .catch(err => console.log(err));
      } else {
        //Update
        fetch("api/facture", {
          method: "PUT",
          body: JSON.stringify(this.facture),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
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

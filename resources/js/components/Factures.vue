<template>
  <div
    style="
      width: 50%;
      margin: auto;
      background-color: white;
      padding: 20px;
      margin-top: 15px;
    "
  >
    <h2 class="center">Gestion de Facture</h2>
    <br />
    <form @submit.prevent="addFacture" method="post" class="mb-3">
      <div class="form-group">
        <select name="category" v-model="facture.client" class="form-control">
          <option value>-- Entreprise --</option>
          <option v-for="entr in entreprises" v-bind:key="entr.entreprise">
            {{ entr.nom_entreprise }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="proforma" style="margin-right: 100px">Proforma</label>
        <input
          type="radio"
          name="proforma"
          value="Oui"
          v-model="facture.proforma"
          @change="CalculNumFacture1"
        />
        <span style="margin-right: 20px">Oui</span>

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
          <option value>-- Type --</option>
          <option v-for="type in types" v-bind:key="type">
            {{ type }}
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
          @keypress="onlyNumber"
          disabled
        />
      </div>

      <div class="form-group">
        <select
          name="condition"
          v-model="facture.condition"
          class="form-control"
        >
          <option disabled value>-- Condition --</option>
          <option v-for="cond in conditions" v-bind:key="cond">
            {{ cond }}
          </option>
        </select>
      </div>

      <div class="form-group">
        <select name="navire" v-model="facture.navire" class="form-control">
          <option disabled value>-- Navire --</option>
          <option v-for="entr in actifNavires" v-bind:key="entr.nom_navire">
            {{ entr.nom_navire }}
          </option>
        </select>
      </div>
      <div class="form-group">
        <label style="margin-right: 100px">Statut</label>
        <input
          type="radio"
          name="statu"
          value="Payé"
          v-model="facture.statut"
        />
        <span style="margin-right: 20px">Payé</span>

        <input
          type="radio"
          name="statu"
          value="Non payé"
          v-model="facture.statut"
        />
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
          <option value>-- Nature --</option>
          <option v-for="nat in natures" v-bind:key="nat">
            {{ nat }}
          </option>
        </select>
      </div>
      <button
        type="submit"
        class="btn btn-primary btn-block"
        style="width: 20%; margin: auto"
      >
        Save
      </button>
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
        type: "",
        condition: "",
        navire: "",
        statut: "",
        date: "", //date format : "2020-03-13"
      },
      types: ["Initial", "Note de crédit"],
      entreprises: [],
      conditions: [
        "Chèque à 10 jrs",
        "Effet à 60 jrs",
        "Réglé sur base proforma",
      ],
      navires: [],
      actifNavires: [],
      natures: ["Marge de transformation", "Fraix d'extension", "Transport"],
      pagination: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
    };
  },
  mounted() {
    this.fetchEntreprises();

    //fetch navires where statut = "En cours"
    this.fetchNavires();

    //initialize date input
    this.dateFormate();

    //initialise num facture and num commande :
    this.fetchFactures();
  },
  methods: {
    CalculNumFacture1() {
      let _this = this;

      //based on proForma
      if (this.facture.proforma == "Non") {
        //non
        this.facture.num_facture = "";
      } else if (this.facture.proforma == "Oui") {
        this.facture.type = "proforma";
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

          var list = [];
          if (this.factures.length == 0) {
            this.facture.num_commande = 1;
          } else {
            for (let index = 0; index < this.factures.length; index++) {
              list.push(this.factures[index].num_commande);
            }
            var max = Math.max.apply(Math, list);
            this.facture.num_commande = max + 1;
          }
        })
        .catch((err) => console.log("error fetching factures"));
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
    onlyNumber($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault();
      }
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
    addFacture() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/facture", {
          method: "POST",
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

            alert("Facture added");
          })
          .catch((err) => console.log(err));
      }
    },
  },
};
</script>

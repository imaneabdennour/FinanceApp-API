<template>
  <div>
    <div class="leftDiv">
      <h2 class="center">Gestion de Facture</h2>
      <br />
      <form @submit.prevent="addFacture" method="post" class="mb-3">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Client</label>
          <div class="col-sm-8">
            <select
              name="category"
              v-model="facture.client"
              class="form-control"
              @change="InfoClient"
            >
              <option value="no value" disabled>-- Entreprise --</option>
              <option v-for="entr in entreprises" v-bind:key="entr.entreprise">
                {{ entr.nom_entreprise }}
              </option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Proforma</label>
          <div class="col-sm-8">
            <input
              type="radio"
              name="proforma"
              value="Oui"
              v-model="facture.proforma"
              @change="CalculNumFacture1"
            />
            <span style="margin-right: 30px">Oui</span>

            <input
              type="radio"
              name="proforma"
              value="Non"
              v-model="facture.proforma"
              @change="CalculNumFacture1"
            />
            <span>Non</span>
          </div>
        </div>

        <div class="form-group row" v-if="facture.proforma == 'Non'">
          <label class="col-sm-4 col-form-label">Type</label>
          <div class="col-sm-8">
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
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Num de facture</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control"
              placeholder="Num de facture"
              v-model="facture.num_facture"
              disabled
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Représentant</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control"
              placeholder="Num de commande"
              v-model="facture.num_commande"
              @keypress="onlyNumber"
              disabled
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Condition</label>
          <div class="col-sm-8">
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
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Navire</label>
          <div class="col-sm-8">
            <select name="navire" v-model="facture.navire" class="form-control">
              <option value disabled>-- Navire --</option>
              <option v-for="entr in actifNavires" v-bind:key="entr.nom_navire">
                {{ entr.nom_navire }}
              </option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Statut</label>
          <div class="col-sm-8">
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
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Date</label>
          <div class="col-sm-8">
            <input
              type="date"
              value="dateFormate"
              class="form-control"
              v-model="facture.date"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Nature</label>
          <div class="col-sm-8">
            <select
              name="navire"
              v-model="facture.nature"
              class="form-control"
              @change="
                pourcentageTVA();
                calculTVA();
                calcul_montant_TTC();
              "
            >
              <option value>-- Nature --</option>
              <option v-for="nat in natures" v-bind:key="nat.nom">
                {{ nat.nom }}
              </option>
            </select>
          </div>
        </div>

        <hr />

        <h3>Produit</h3>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Produit</label>
          <div class="col-sm-8">
            <select
              name="navire"
              v-model="facture.produit"
              class="form-control"
            >
              <option value>-- Produits --</option>
              <option v-for="prod in produits" v-bind:key="prod">
                {{ prod }}
              </option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Quantité</label>
          <div class="col-sm-8">
            <input
              type="number"
              class="form-control"
              v-model="facture.quantite"
              @change="
                calcul_montant_HT();
                calculTVA();
                calcul_montant_TTC();
              "
              min="0.01"
              step="0.01"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Prix unitaire</label>
          <div class="col-sm-8">
            <input
              type="number"
              class="form-control"
              v-model="facture.prix_unit"
              @change="
                calcul_montant_HT();
                calculTVA();
                calcul_montant_TTC();
              "
              min="0.01"
              step="0.01"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Montant HT</label>
          <div class="col-sm-8">
            <input
              type="number"
              class="form-control"
              v-model="facture.montant_HT"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Taux TVA ( % )</label>
          <div class="col-sm-8">
            <input
              type="number"
              value="dateFormate"
              class="form-control"
              v-model="facture.taux_TVA"
              disabled
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">TVA</label>
          <div class="col-sm-8">
            <input
              type="text"
              value="dateFormate"
              class="form-control"
              v-model="facture.TVA"
              @change="calcul_montant_TTC"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Montant TTC</label>
          <div class="col-sm-8">
            <input
              type="text"
              value="dateFormate"
              class="form-control"
              v-model="facture.montant_TTC"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Devise</label>
          <div class="col-sm-8">
            <select
              name="navire"
              v-model="facture.devise"
              class="form-control"
              @change="calcul_montant_TTC"
            >
              <option value disabled>-- Devises --</option>
              <option v-for="dev in devises" v-bind:key="dev.nom">
                {{ dev.nom }}
              </option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Montant en lettres</label>
          <div class="col-sm-8">
            <input
              type="text"
              value="dateFormate"
              class="form-control"
              v-model="facture.montant_en_lettres"
            />
          </div>
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

    <div v-if="myEntreprise.nom_entreprise" class="rightDiv">
      <h3 class="center">Informations sur {{ myEntreprise.nom_entreprise }}</h3>
      <br />

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Adresse</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Adresse"
            v-model="myEntreprise.adresse"
            disabled
          />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Ville</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Ville"
            v-model="myEntreprise.ville"
            disabled
          />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Num de compte bancaire</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Num de compte bancaire"
            v-model="myEntreprise.num_compte_bancaire"
            disabled
          />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">RC</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="RC"
            v-model="myEntreprise.RC"
            disabled
          />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">ICE</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="ICE"
            v-model="myEntreprise.ICE"
            disabled
          />
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
        type: "",
        condition: "",
        navire: "",
        statut: "",
        date: "", //date format : "2020-03-13"

        produit: "",
        quantite: "",
        prix_unit: "",
        montant_HT: "",
        taux_TVA: "",
        TVA: "",
        montant_TTC: "",
        devise: "",
        montant_en_lettres: "",
      },

      produits: [
        "Maïs",
        "Soja",
        "Blé",
        "Orge",
        "Tournesol",
        "Colza",
        "Céréales",
      ],

      types: ["Initial", "Note de crédit"],
      entreprises: [],
      myEntreprise: [],
      conditions: [
        "Chèque à 10 jrs",
        "Effet à 60 jrs",
        "Réglé sur base proforma",
      ],
      navires: [],
      actifNavires: [],
      natures: [
        { nom: "Marge de transformation", valeur_TVA: 0.2 },
        { nom: "Fraix d'extension", valeur_TVA: 0.2 },
        { nom: "Transport", valeur_TVA: 0.14 },
      ],
      devises: [
        { nom: "Dollar", sign: "$", centimes: "cents" },
        { nom: "Euro", sign: "€", centimes: "cents" },
        { nom: "Pound", sign: "£", centimes: "pence" },
        { nom: "MAD", sign: "MAD", centimes: "centimes" },
      ],
      pagination: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
    };
  },
  created() {
    this.fetchEntreprises();

    //fetch navires where statut = "En cours"
    this.fetchNavires();

    //initialize date input
    this.dateFormate();

    //initialise num facture and num commande :
    this.fetchFactures();
  },
  methods: {
    montantChiffres() {
      if (this.facture.devise) {
        this.facture.montant_en_lettres = "RR";
      }
    },
    calcul_montant_TTC() {
      if (this.facture.montant_HT && this.facture.TVA) {
        this.facture.montant_TTC = this.facture.montant_HT - this.facture.TVA;

        this.montantChiffres(); //transformation en lettres
      }
    },
    calculTVA() {
      if (this.facture.montant_HT && this.facture.taux_TVA) {
        this.facture.TVA =
          "" +
          ((this.facture.montant_HT * this.facture.taux_TVA) / 100).toFixed(8);
      }
    },
    pourcentageTVA() {
      for (let i = 0; i < this.natures.length; i++) {
        if (this.natures[i].nom == this.facture.nature) {
          this.facture.taux_TVA =
            "" + (this.natures[i].valeur_TVA * 100).toFixed(0);
        }
      }
    },
    calcul_montant_HT() {
      if (this.facture.quantite && this.facture.prix_unit) {
        this.facture.montant_HT =
          "" + (this.facture.quantite * this.facture.prix_unit).toFixed(7);
      }
    },
    InfoClient() {
      // search for object with nom_entreprise = this.facture.client
      for (let i = 0; i < this.entreprises.length; i++) {
        if (this.entreprises[i].nom_entreprise == this.facture.client) {
          this.myEntreprise = this.entreprises[i];
        }
      }
    },

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
      let y = "";

      if (month >= 10) {
        z = "";
      }
      if (day < 10) {
        y = "0";
      }

      this.facture.date = year + "-" + z + month + "-" + y + day;
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

<style scoped>
.leftDiv {
  width: 50%;
  background-color: white;
  padding: 15px;
  margin-top: 15px;
  float: left;
}
.rightDiv {
  width: 45%;
  background-color: #c5d5c5;
  padding: 15px;
  margin-top: 100px;
  float: right;
}
</style>

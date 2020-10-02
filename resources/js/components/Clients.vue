<template>
  <div>
    <div class="leftDiv">
      <h2 class="center">Ajouter un client</h2>
      <br />

      <form @submit.prevent="addClient" method="post" class="mb-4">
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Nom de l'entreprise</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control"
              placeholder="Nom de l'entreprise"
              v-model="client.nom_entreprise"
            />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Adresse</label>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control"
              placeholder="Adresse"
              v-model="client.adresse"
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
              v-model="client.ville"
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
              v-model="client.num_compte_bancaire"
              maxlength="16"
              minlength="16"
              @keypress="onlyNumber"
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
              v-model="client.RC"
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
              v-model="client.ICE"
            />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Représentant</label>
          <div class="col-sm-8">
            <select
              name="category"
              v-model="client.representant"
              class="form-control"
              @change="InfoContact"
            >
              <option disabled value>-- Choisissez le représentant --</option>
              <option
                v-for="rep in representants"
                v-bind:key="rep.id"
                :value="rep.id"
              >
                {{ rep.nom_complet }}
              </option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Catégorie</label>
          <div class="col-sm-8">
            <select
              name="category"
              v-model="client.category"
              class="form-control"
            >
              <option disabled value>-- Catégorie --</option>
              <option v-for="cat in categories" v-bind:key="cat">
                {{ cat }}
              </option>
            </select>
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

    <div v-if="client.representant" class="rightDivClient">
      <h3 class="center">
        Informations sur <b>{{ myContact.nom_complet }}</b>
      </h3>
      <br />

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Nom complet</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Adresse"
            v-model="myContact.nom_complet"
            disabled
          />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">email</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Adresse"
            v-model="myContact.email"
            disabled
          />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Num de telefone</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Adresse"
            v-model="myContact.telef"
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
        representant: "",
      },
      representants: [], //list of contacts
      myContact: [],
      categories: ["Fournisseur", "Client"],
      pagination: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
    };
  },
  created() {
    this.fetchContacts();
  },
  methods: {
    InfoContact() {
      // search for object with id = this.client.representant
      for (let i = 0; i < this.representants.length; i++) {
        if (this.representants[i].id == this.client.representant) {
          this.myContact = this.representants[i];
        }
      }
    },
    fetchContacts() {
      fetch("/api/contacts")
        .then((res) => res.json()) //formate the data to json format
        .then((res) => {
          this.index = res.meta.last_page;
          this.representants = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/contacts?page=" + i)
                .then((res) => res.json()) //formate the data to json format
                .then((res) => {
                  //res is an object
                  this.representants = this.representants.concat(res.data);
                });
            }
          }
        });
    },
    addClient() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/client", {
          method: "POST",
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

            alert("Client added");
            this.fetchClients();
          })
          .catch((err) => console.log(err));
      }
    },
    onlyNumber($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = $event.keyCode ? $event.keyCode : $event.which;
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
        // 46 is dot
        $event.preventDefault();
      }
    },
  },
};
</script>
<style scoped>
.rightDivClient {
  width: 45%;
  background-color: #c5d5c5;
  padding: 15px;
  margin-bottom: 90px;
  margin-top: 450px;
  float: right;
}
</style>

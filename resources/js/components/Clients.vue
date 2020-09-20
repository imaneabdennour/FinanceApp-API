<template>
  <div style="width:50%; margin:auto; background-color:white;padding:20px; margin-top:15px;">
    <h2 class="center">Ajouter un client</h2>
    <br />

    <form @submit.prevent="addClient" method="post" class="mb-4">
      <div class="form-group">
        <input
          type="text"
          class="form-control"
          placeholder="Nom de l'entreprise"
          v-model="client.nom_entreprise"
        />
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Adresse" v-model="client.adresse" />
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Ville" v-model="client.ville" />
      </div>
      <div class="form-group">
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
      <div class="form-group">
        <input type="text" class="form-control" placeholder="RC" v-model="client.RC" />
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="ICE" v-model="client.ICE" />
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
    };
  },
  methods: {
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

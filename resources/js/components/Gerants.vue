<template>
  <div style="width:50%; margin:auto; background-color:white;padding:20px; margin-top:15px;">
    <h2 class="center">Ajouter un gérant</h2>
    <br />

    <form @submit.prevent="addGerant" method="post" class="mb-3">
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
        <input type="email" class="form-control" placeholder="Email" v-model="gerant.email" />
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
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
      index: 0,
    };
  },
  created() {
    this.fetchEntreprises();
  },
  mounted() {},
  methods: {
    onInput(formattedNumber, { number, valid, country }) {
      this.gerant.telef = number.international;
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
    addGerant() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/gerant", {
          method: "POST",
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

            alert("Gerant added");
            this.fetchGerants();
          })
          .catch((err) => console.log(err));
      } else {
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

<template>
  <div style="width:50%; margin:auto; background-color:white;padding:20px; margin-top:15px;">
    <h2 class="center">Ajouter un navire</h2>
    <br />

    <form @submit.prevent="addNavire" method="post" class="mb-3">
      <div class="form-group">
        <label>Nom du navire</label>
        <input
          type="text"
          class="form-control"
          placeholder="Nom du navire"
          v-model="navire.nom_navire"
        />
      </div>
      <div class="form-group">
        <label>Statut</label>
        <select name="category" v-model="navire.statut" class="form-control">
          <option disabled value>Statut</option>
          <option v-for="stat in status" v-bind:key="stat">{{stat}}</option>
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
      navires: [],
      navire: {
        nom_navire: "",
        statut: "",
      },
      status: ["En cours", "Archivé"],
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
    };
  },
  methods: {
    addNavire() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/navire", {
          method: "POST",
          body: JSON.stringify(this.navire),
          headers: {
            "content-type": "application/json",
          },
        })
          .then((res) => res.json())
          .then((data) => {
            //we wanna clear the form : empty it bcz it's binded with the inputs
            (this.navire.nom_navire = ""),
              (this.navire.statut = ""),
              alert("Navire added");
            this.fetchNavires();
          })
          .catch((err) => console.log(err));
      } else {
        //Update
        fetch("api/navire", {
          method: "PUT",
          body: JSON.stringify(this.navire),
          headers: {
            "content-type": "application/json",
          },
        })
          .then((res) => res.json())
          .then((data) => {
            //we wanna clear the form : empty it bcz it's binded with the inputs
            (this.navire.nom_navire = ""),
              (this.navire.statut = ""),
              alert("Navire updated");
            this.fetchNavires();
          })
          .catch((err) => console.log(err));
      }
    },
    editNavire(navire) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.navire.nom_navire = navire.nom_navire;
      this.navire.statut = navire.statut;
    },
  },
};
</script>

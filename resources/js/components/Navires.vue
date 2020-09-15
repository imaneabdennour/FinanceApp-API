<template>
  <div style="width:50%; margin:auto;">
    <h2>Navires</h2>

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
        statut: ""
      },
      status: ["En cours", "Archivé"],
      pagination: {},
      edit: false //same form to add and edit => if edit : we're going to update so edit = true
    };
  },
  created() {
    //fetch navires :
    this.fetchNavires();
  },
  methods: {
    fetchNavires(page_url) {
      //depends on pagination
      let vm = this;
      page_url = page_url || "/api/navires";
      fetch(page_url)
        .then(res => res.json()) //formate the data to json format
        .then(res => {
          //res is an object
          this.navires = res.data;
          vm.makePagination(res.meta, res.links); //for pagination purposes
        })
        .catch(err => console.log("error fetching navires"));
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
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
    deleteNavire(nom_navire) {
      //make delete request to our api
      if (confirm("Are you sure ? ")) {
        fetch("api/navire/" + nom_navire, {
          method: "delete"
        })
          .then(res => res.json()) //formate the data to json format
          .then(data => {
            //data is an object
            alert("Navire deleted");
            this.fetchNavires();
          })
          .catch(err => console.log(err));
      }
    },
    addNavire() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/navire", {
          method: "POST",
          body: JSON.stringify(this.navire),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            //we wanna clear the form : empty it bcz it's binded with the inputs
            (this.navire.nom_navire = ""),
              (this.navire.statut = ""),
              alert("Navire added");
            this.fetchNavires();
          })
          .catch(err => console.log(err));
      } else {
        //Update
        fetch("api/navire", {
          method: "PUT",
          body: JSON.stringify(this.navire),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            //we wanna clear the form : empty it bcz it's binded with the inputs
            (this.navire.nom_navire = ""),
              (this.navire.statut = ""),
              alert("Navire updated");
            this.fetchNavires();
          })
          .catch(err => console.log(err));
      }
    },
    editNavire(navire) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.navire.nom_navire = navire.nom_navire;
      this.navire.statut = navire.statut;
    }
  }
};
</script>

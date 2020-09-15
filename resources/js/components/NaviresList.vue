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
                    @click="fetchNavires(pagination.prev_page_url)"
                  >Previous</a>
                </li>

                <li class="page-item disabled">
                  <a
                    href="#"
                    class="page-link text-dark"
                  >Page {{pagination.current_page}} of {{pagination.last_page}}</a>
                </li>

                <li class="page-item" v-bind:class="[{ disabled: !pagination.next_page_url }]">
                  <a class="page-link" href="#" @click="fetchNavires(pagination.next_page_url)">Next</a>
                </li>
              </ul>
            </nav>
            <div class="row">
              <div class="col-sm-8">
                <h2>
                  Navires
                  <b>Details</b>
                </h2>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-info add-new">
                  <i class="fa fa-plus"></i>
                  <router-link :to="{ name: 'navires' }">Add New</router-link>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="navire in navires" :key="navire.nom_navire">
                <td>{{navire.nom_navire}}</td>
                <td>{{navire.statut}}</td>
                <td>
                  <a class="add" title="Add" data-toggle="tooltip">
                    <i class="material-icons">&#xE03B;</i>
                  </a>
                  <a class="edit" title="Edit" data-toggle="tooltip">
                    <i class="material-icons">&#xE254;</i>
                    <!--<button @click="editGerant(gerant)" class="btn btn-warning">Edit</button>
                    -->
                  </a>
                  <a
                    class="delete"
                    title="Delete"
                    data-toggle="tooltip"
                    @click="deleteNavire(navire.nom_navire)"
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
  </div>
  <!--finish-->
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


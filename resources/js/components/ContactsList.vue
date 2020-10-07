<template>
  <!--start-->
  <div>
    <div class="container-lg">
      <div class="table-responsive">
        <div class="table-wrapper">
          <div class="table-title">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li
                  class="page-item"
                  v-bind:class="[{ disabled: !pagination.prev_page_url }]"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="fetchContacts(pagination.prev_page_url)"
                    >Previous</a
                  >
                </li>

                <li class="page-item disabled">
                  <a href="#" class="page-link text-dark">
                    Page {{ pagination.current_page }} of
                    {{ pagination.last_page }}
                  </a>
                </li>

                <li
                  class="page-item"
                  v-bind:class="[{ disabled: !pagination.next_page_url }]"
                >
                  <a
                    class="page-link"
                    href="#"
                    @click="fetchContacts(pagination.next_page_url)"
                    >Next</a
                  >
                </li>
              </ul>
            </nav>
            <div class="row">
              <div class="col-sm-8">
                <h2>
                  Contacts
                  <b>Details</b>
                </h2>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-info add-new">
                  <i class="fa fa-plus"></i>
                  <router-link :to="{ name: 'contacts' }" style="color: white"
                    >Add New</router-link
                  >
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Civilité</th>
                <th>Nom complet</th>
                <th style="width: 270px">Email</th>
                <th>Num telef</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="contact in contacts" :key="contact.id">
                <td>{{ contact.civilité }}</td>
                <td>{{ contact.nom_complet }}</td>
                <td>{{ contact.email }}</td>
                <td>{{ contact.telef }}</td>
                <td>
                  <a
                    class="edit"
                    title="Edit"
                    data-toggle="tooltip"
                    @click="
                      editContact(contact);
                      openModel();
                    "
                  >
                    <i class="material-icons">&#xE254;</i>
                  </a>
                  <a
                    class="delete"
                    title="Delete"
                    data-toggle="tooltip"
                    @click="deleteContact(contact.id)"
                  >
                    <i class="material-icons">&#xE872;</i>
                  </a>
                  <i class="fa fa-print" aria-hidden="true"></i>
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
                    <form
                      @submit.prevent="addContact"
                      method="post"
                      class="mb-3"
                    >
                      <button
                        type="button"
                        class="close"
                        @click="myModel = false"
                      >
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <div class="form-group">
                        <label for="civilité" style="margin-right: 100px"
                          >Civilité :</label
                        >
                        <input
                          type="radio"
                          name="civilité"
                          value="Mdm"
                          v-model="contact.civilité"
                        />
                        <span style="margin-right: 20px">Mdm</span>

                        <input
                          type="radio"
                          name="civilité"
                          value="Mr"
                          v-model="contact.civilité"
                        />
                        <span>Mr</span>
                      </div>

                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Nom complet"
                          v-model="contact.nom_complet"
                        />
                      </div>

                      <div class="form-group">
                        <input
                          type="email"
                          class="form-control"
                          placeholder="Email"
                          v-model="contact.email"
                        />
                      </div>

                      <div class="form-group">
                        <vue-tel-input
                          validCharactersOnly="true"
                          placeholder="Entrer un num de telef"
                          class="form-control"
                          @input="onInput"
                        ></vue-tel-input>
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
  <!--finish-->
</template>

<script>
export default {
  data() {
    return {
      contacts: [],
      contact: {
        id: "",
        civilité: "",
        nom_complet: "",
        email: "",
        telef: "",
      },
      pagination: {},
      paginationClient: {},
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
      index: 0,

      myModel: false,
    };
  },
  created() {
    //fetch contacts :
    this.fetchContacts();
  },
  methods: {
    addContact() {
      //Update
      fetch("api/contact", {
        method: "PUT",
        body: JSON.stringify(this.contact),
        headers: {
          "content-type": "application/json",
        },
      })
        .then((res) => res.json())
        .then((data) => {
          //we wanna clear the form : empty it bcz it's binded with the inputs
          this.contact.id = "";
          this.contact.civilité = "";
          this.contact.nom_complet = "";
          this.contact.email = "";
          this.contact.telef = "";

          alert("Contact updated");
          this.fetchContacts();
          this.myModel = false;
        })
        .catch((err) => console.log(err));
    },
    openModel() {
      this.myModel = true;
    },
    fetchContacts() {
      fetch("/api/contacts")
        .then((res) => res.json())
        .then((res) => {
          this.index = res.meta.last_page;
          this.contacts = res.data;

          if (this.index != 1) {
            for (let i = 2; i <= this.index; i++) {
              fetch("/api/contacts?page=" + i)
                .then((res) => res.json())
                .then((res) => {
                  this.contacts = this.contacts.concat(res.data);
                });
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
    deleteContact(id) {
      //make delete request to our api
      if (confirm("Are you sure ? ")) {
        fetch("api/contact/" + id, {
          method: "delete",
        })
          .then((res) => res.json()) //formate the data to json format
          .then((data) => {
            //data is an object
            alert("Contact deleted");
            this.fetchContacts();
          })
          .catch((err) => console.log(err));
      }
    },
    editContact(contact) {
      // change value of edit, then the form kiyakhd l values of my client
      // => then when i click save i update the client (calling addClient)
      this.edit = true;

      this.contact.id = contact.id;
      this.contact.civilité = contact.civilité;
      this.contact.nom_complet = contact.nom_complet;
      this.contact.email = contact.email;
      this.contact.telef = contact.telef;
    },
  },
};
</script>

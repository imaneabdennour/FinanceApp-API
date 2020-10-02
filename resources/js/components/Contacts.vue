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
    <h2 class="center">Ajouter un contact</h2>
    <br />

    <form @submit.prevent="addContact" method="post" class="mb-3">
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Civilité</label>
        <div class="col-sm-4">
          <input
            type="radio"
            name="civilité"
            value="Mdm"
            v-model="contact.civilité"
          />
          <span style="margin-right: 20px">Mdm</span>
        </div>

        <div class="col-sm-4">
          <input
            type="radio"
            name="civilité"
            value="Mr"
            v-model="contact.civilité"
          />
          <span>Mr</span>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Nom complet</label>
        <div class="col-sm-8">
          <input
            type="text"
            class="form-control"
            placeholder="Nom complet"
            v-model="contact.nom_complet"
          />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8">
          <input
            type="email"
            class="form-control"
            placeholder="contact@gmail.com"
            v-model="contact.email"
          />
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Num de telefone</label>
        <div class="col-sm-8">
          <vue-tel-input
            validCharactersOnly="true"
            placeholder="Entrer un num de telef"
            class="form-control"
            @input="onInput"
          ></vue-tel-input>
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
      edit: false, //same form to add and edit => if edit : we're going to update so edit = true
      index: 0,
    };
  },
  mounted() {},
  methods: {
    onInput(formattedNumber, { number, valid, country }) {
      this.contact.telef = number.international;
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
    addContact() {
      //used for add and update
      if (this.edit === false) {
        //Add
        fetch("api/contact", {
          method: "POST",
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

            alert("Contact added");
            this.fetchContacts();
          })
          .catch((err) => console.log(err));
      }
    },
    editContacts(contact) {
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

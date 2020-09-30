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
    <h2 class="center">Ajouter un gérant</h2>
    <br />

    <form @submit.prevent="addContact" method="post" class="mb-3">
      <div class="form-group">
        <label for="civilité" style="margin-right: 100px">Civilité :</label>
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

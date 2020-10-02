import "./bootstrap";
import Vue from "vue";
import VueRouter from "vue-router";
import BootstrapVue from "bootstrap-vue";

Vue.use(BootstrapVue);
Vue.use(VueRouter);

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

import Style from "@/js//components/Style.vue";
import Navbar from "@/js//components/Navbar.vue";
import Clients from "@/js//components/Clients.vue";
import ClientsList from "@/js//components/ClientsList.vue";
import Factures from "@/js//components/Factures.vue";
import FacturesList from "@/js//components/FacturesList.vue";
import Contacts from "@/js//components/Contacts.vue";
import ContactsList from "@/js//components/ContactsList.vue";
import Navires from "@/js//components/Navires.vue";
import NaviresList from "@/js//components/NaviresList.vue";

import VueTelInput from "vue-tel-input";

Vue.use(VueTelInput);

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "clients",
            component: Clients
        },
        {
            path: "/factures",
            name: "factures",
            component: Factures
        },
        {
            path: "/contacts",
            name: "contacts",
            component: Contacts
        },
        {
            path: "/navires",
            name: "navires",
            component: Navires
        },
        {
            path: "/facturesList",
            name: "facturesList",
            component: FacturesList
        },
        {
            path: "/clientsList",
            name: "clientsList",
            component: ClientsList
        },
        {
            path: "/naviresList",
            name: "naviresList",
            component: NaviresList
        },
        {
            path: "/contactsList",
            name: "contactsList",
            component: ContactsList
        }
    ]
});

const app = new Vue({
    el: "#app",
    components: {
        Navbar,
        Clients,
        Factures,
        FacturesList,
        Contacts,
        ContactsList,
        Navires,
        ClientsList,
        Style
    },
    router
});

//export default app;

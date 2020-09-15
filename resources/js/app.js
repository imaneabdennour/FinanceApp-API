import "./bootstrap";
import Vue from "vue";
import VueRouter from "vue-router";
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(VueRouter);

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import Navbar from "@/js//components/Navbar.vue";
import Clients from "@/js//components/Clients.vue";
import ClientsList from "@/js//components/ClientsList.vue";
import Factures from "@/js//components/Factures.vue";
import FacturesList from "@/js//components/FacturesList.vue";
import Gerants from "@/js//components/Gerants.vue";
import GerantsList from "@/js//components/GerantsList.vue";
import Navires from "@/js//components/Navires.vue";
import NaviresList from "@/js//components/NaviresList.vue";

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
            path: "/gerants",
            name: "gerants",
            component: Gerants
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
            path: "/gerantsList",
            name: "gerantsList",
            component: GerantsList
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
        Gerants,
        GerantsList,
        Navires,
        ClientsList
    },
    router
});

//export default app;

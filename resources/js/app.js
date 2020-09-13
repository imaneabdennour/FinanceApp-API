import "./bootstrap";
import Vue from "vue";
//import VueRouter from "vue-router";

import Navbar from "@/js//components/Navbar.vue";
import Clients from "@/js//components/Clients.vue";
import Factures from "@/js//components/Factures.vue";
import Gerants from "@/js//components/Gerants.vue";
import Navires from "@/js//components/Navires.vue";

//import AppTopBar from "./AppTopbar.vue";

const app = new Vue({
    el: "#app",
    // vuetify: new Vuetify(),
    components: {
        //AppTopBar,
        Navbar,
        Clients,
        Factures,
        Gerants,
        Navires
    }
});

//export default app;

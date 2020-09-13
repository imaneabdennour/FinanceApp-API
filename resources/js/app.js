import "./bootstrap";
import Vue from "vue";

import Navbar from "@/js//components/Navbar.vue";
import Clients from "@/js//components/Clients.vue";

//import AppTopBar from "./AppTopbar.vue";

const app = new Vue({
    el: "#app",
    // vuetify: new Vuetify(),
    components: {
        //AppTopBar,
        Navbar,
        Clients
    }
});

//export default app;

import "./bootstrap";
import Vue from "vue";

import Home from "@/js//components/Home.vue";
import Navbar from "@/js//components/Navbar.vue";
import Clients from "@/js//components/Clients.vue";

//import AppTopBar from "./AppTopbar.vue";

const app = new Vue({
    el: "#app",
    // vuetify: new Vuetify(),
    components: {
        Home,
        //AppTopBar,
        Navbar,
        Clients
    }
});

//export default app;

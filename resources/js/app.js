/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";
import Vue from "vue";
//import Vuetify from "vuetify";

//window.Vue = require("vue");

//Vue.use(Vuetify);

//Vue.component("clients", require("./components/Clients.vue"));
//Vue.component("navbar", require("./components/Navbar.vue"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Home from "@/js/components/Home";

const app = new Vue({
    el: "#app",
    // vuetify: new Vuetify(),
    components: {
        Home
    }
});

//export default app;

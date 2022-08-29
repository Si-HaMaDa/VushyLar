/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import "./bootstrap";
import "admin-lte";
import { createApp } from "vue";
import router from "./router";

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({
    data() {
        return {
            search: "",
        };
    },
    methods: {
        sendSearch: _.debounce(function () {
            this.emitter.emit("sendSearch");
        }, 1000),
    },
    watch: {
        search: function () {
            this.sendSearch();
        },
    },
});

app.use(router);

// Import Vfrom and register it as global
import Form from "vform";
window.Form = Form;
import { HasError, AlertError } from "vform/src/components/bootstrap5";
app.component(HasError.name, HasError);
app.component(AlertError.name, AlertError);

import ExampleComponent from "./components/ExampleComponent.vue";
app.component("example-component", ExampleComponent);

import LaravelVuePagination from "laravel-vue-pagination";
app.component("LaravelVuePagination", LaravelVuePagination);
import NotFound from "./components/NotFound.vue";
app.component("NotFound", NotFound);

// Add some custom directives
app.directive("UpLetter", (el, binding) => {
    let text = binding.value;
    el.innerText = text.charAt(0).toUpperCase() + text.slice(1);
});
import moment from "moment";
app.directive("date", (el, binding) => {
    let text = binding.value;
    el.innerText = moment(text).format("MMM Do YYYY");
});

// Add progress bar
import VueProgressBar from "@aacassandra/vue3-progressbar";
const options = {
    color: "#bffaf3",
    failedColor: "#874b4b",
    thickness: "5px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300,
    },
    autoRevert: true,
    location: "top",
    inverse: false,
};
app.use(VueProgressBar, options);

// Add Sweetalert2
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
app.use(VueSweetalert2);

// Register  Emmiter
import mitt from "mitt";
import _ from "lodash";
const emitter = mitt();
app.config.globalProperties.emitter = emitter;

import Gate from "./Gate";
app.config.globalProperties.gate = new Gate(window.user);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.globEager('./**/*.vue')).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount("#app");

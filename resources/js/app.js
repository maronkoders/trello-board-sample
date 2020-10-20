window.Vue = require("vue");
import Routes from "./routes.js";

Vue.component("home", require("./components/dashboard/home.vue").default);

const app = new Vue({
    el: "#contents",
    router: Routes,
});
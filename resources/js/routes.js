import Vue from "vue";
import VueRouter from "vue-router";

import home from "@/js/components/dashboard/home.vue";
import addClient from "@/js/components/dashboard/addClient.vue";
import clients from "@/js/components/dashboard/clients.vue";
import editClient from "@/js/components/dashboard/editClient.vue";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [{
            path: "/home",
            name: "home",
            component: home
        },
        {
            path: "/addClient",
            name: "addClient",
            component: addClient
        },
        {
            path: "/clients",
            name: "clients",
            component: clients
        },
        {
            path: "/editClient",
            name: "editClient",
            component: editClient
        }
    ]
});
export default router;
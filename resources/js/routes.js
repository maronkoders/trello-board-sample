import Vue from "vue";
import VueRouter from "vue-router";
import home from "@/js/components/dashboard/home.vue";


Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [{
            path: "/home",
            name: "home",
            component: home
        },
    ]
});
export default router;
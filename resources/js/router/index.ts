import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
    {
        path: "/dashboard",
        name: "Home",
        component: () => import("../views/Home.vue"),
    },
    {
        path: "/dashboard/welcome",
        name: "Welcome",
        component: () => import("../views/Welcome.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

export default router;

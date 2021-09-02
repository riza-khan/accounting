import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
	{
		path: "/dashboard",
		name: "Home",
		component: () => import("../views/Home.vue"),
	},
	{
		path: "/dashboard/import",
		name: "Import",
		component: () => import("../views/Import.vue"),
	},
	{
		path: "/dashboard/confirm",
		name: "Confirm",
		component: () => import("../views/Confirm.vue"),
	},
];

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes,
});

export default router;

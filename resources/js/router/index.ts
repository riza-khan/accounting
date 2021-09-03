import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
	{
		path: "/dashboard",
		name: "Dashboard",
		component: () => import("../views/Dashboard.vue"),
		children: [
			{
				path: "confirm",
				name: "Confirm",
				component: () => import("../views/Confirm.vue"),
			},
			{
				path: "company",
				name: "Company",
				component: () => import("../views/Company.vue"),
				redirect: { name: "Information" },
				children: [
					{
						path: "information",
						name: "Information",
						component: () => import("../views/Information.vue"),
					},
					{
						path: "categories",
						name: "Categories",
						component: () => import("../views/Categories.vue"),
					},
					{
						path: "import",
						name: "Import",
						component: () => import("../views/Import.vue"),
					},
				],
			},
		],
	},
];

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes,
});

export default router;

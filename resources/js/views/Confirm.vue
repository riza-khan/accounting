<template>
	<h1>Confirm!</h1>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Axios from "../api";
import store from "../store";

export default defineComponent({
	name: "Confirm",
	beforeRouteEnter(to, from, next) {
		const { code, realmId } = to.query;

		if (code && realmId) {
			Axios.post("/api/quickbooks/connect", {
				code,
				realmId,
			})
				.then(() => {
					Axios.get("/api/quickbooks/company")
						.then(({ data }) => {
							store.commit("setCompany", data.company);
							next({ name: "Company" });
						})
						.catch((e) => console.log(e));
				})
				.then((e: any) => console.log(e))
				.catch((e) => console.log(e));
		}
	},
	setup() {
		return {};
	},
});
</script>


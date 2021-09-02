<template>
	<h1>Confirm!</h1>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Axios from "../api";

export default defineComponent({
	name: "Confirm",
	beforeRouteEnter(to, from, next) {
		const { code, realmId } = to.query;
		if (code && realmId) {
			Axios.post("/api/quickbooks/connect", {
				code,
				realmId,
			})
				.then(() => next({ name: "Company" }))
				.then((e: any) => console.log(e));
		}
	},
	setup() {
		return {};
	},
});
</script>


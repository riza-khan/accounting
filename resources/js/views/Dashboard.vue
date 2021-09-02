<template>
	<router-view />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Axios from "../api";
import _ from "lodash";
import store from "../store";

export default defineComponent({
	name: "Dashboard",
	beforeRouteEnter(to, from, next) {
		next(() => {
			const company = store.getters["getCompany"];
			if (_.isEmpty(company)) {
				Axios.get("/api/quickbooks/connect")
					.then(({ data }) => {
						window.location = data;
					})
					.catch((e) => console.log(e));
			} else {
				next({ name: "Company" });
			}
		});
	},
	setup() {
		return {};
	},
});
</script>


<template>
	<h1>Information about the company</h1>
	<h1>Company</h1>
	<pre>{{ company }}</pre>
</template>

<script lang="ts">
import { defineComponent, computed, onMounted } from "vue";
import { useStore } from "vuex";
import { isEmpty } from "lodash";
import Axios from "../api";

export default defineComponent({
	name: "Information",
	setup() {
		const store = useStore();
		const company = computed(() => store.getters["getCompany"]);

		onMounted(() => {
			if (isEmpty(company.value)) {
				getInfo();
			}
		});

		const getInfo = () => {
			Axios.get("/api/quickbooks/company")
				.then(({ data }) => {
					store.commit("setCompany", data.company);
				})
				.catch((e) => console.log(e));
		};

		return {
			company,
		};
	},
});
</script>




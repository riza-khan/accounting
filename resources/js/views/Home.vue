<template>
	<div v-if="company && invoices.length">
		<h1>Company</h1>
		<pre>{{ company }}</pre>
		<h1>Invoices</h1>
		<pre>{{ invoices }}</pre>
	</div>
	<div v-else>
		<p>No realm selected, please connect using the above function</p>
	</div>

	<button @click="getInfo">Get Info</button>
</template>

<script lang="ts">
import Paginator from "../components/molecules/Paginator.vue";
import { defineComponent, ref } from "vue";
import Axios from "../api";

export default defineComponent({
	components: { Paginator },
	setup() {
		const company = ref({});
		const invoices = ref([]);

		const getInfo = () => {
			Axios.get("/api/quickbooks/company")
				.then(({ data }) => {
					console.log(data);
					company.value = data.company;
					invoices.value = data.invoices.map(({ TotalAmt }: any) => ({
						TotalAmt,
					}));
				})
				.catch((e) => console.log(e));
		};

		return { company, invoices, getInfo };
	},
});
</script>


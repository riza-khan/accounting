<template>
	<h1>Company in question</h1>

	<button @click="batchUploadInvoices">Batch Upload Invoices</button>

	<h1>Company</h1>
	<pre>{{ company }}</pre>

	<h1>Invoices</h1>
	<pre>{{ invoices }}</pre>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import Axios from "../api";

export default defineComponent({
	name: "Company",
	setup() {
		const company = ref({});
		const invoices = ref([]);

		onMounted(() => {
			getInfo();
		});

		const getInfo = () => {
			Axios.get("/api/quickbooks/company")
				.then(({ data }) => {
					company.value = data.company;
					invoices.value = data.invoices.map(({ TotalAmt }: any) => ({
						TotalAmt,
					}));
				})
				.catch((e) => console.log(e));
		};

		const batchUploadInvoices = () => {
			Axios.get("/api/quickbooks/batch-invoices")
				.then((res) => console.log(res))
				.catch((e) => console.log(e));
		};

		return {
			company,
			invoices,
			batchUploadInvoices,
		};
	},
});
</script>


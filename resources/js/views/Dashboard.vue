<template>
	<router-view />
</template>

<script lang="ts">
import Paginator from "../components/molecules/Paginator.vue";
import { defineComponent, ref } from "vue";
import Axios from "../api";

export default defineComponent({
	name: "Home",
	components: { Paginator },
	setup() {
		const company = ref({});
		const invoices = ref([]);

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
			getInfo,
			batchUploadInvoices,
		};
	},
});
</script>


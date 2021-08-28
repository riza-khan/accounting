<template>
	<div v-if="targetRealm">{{ targetRealm }}</div>
	<div v-else>
		<p>No realm selected, please connect using the above function</p>
	</div>

	<button @click="getInfo">Get Info</button>
</template>

<script lang="ts">
import Paginator from "../components/molecules/Paginator.vue";
import { defineComponent, onMounted, ref, reactive, watchEffect } from "vue";
import Axios from "../api";

export default defineComponent({
	components: { Paginator },
	setup() {
		const companies = ref([]);
		const meta = reactive({
			current_page: 1,
			per_page: 15,
			total: 0,
		});

		const getData = (model: string, params?: string) => {
			Axios.get(`/api/${model}${params ?? ""}`).then(({ data }) => {
				const { per_page, total } = data;
				companies.value = data.data;
				meta.per_page = per_page;
				meta.total = total;
			});
		};

		watchEffect(() => {
			const params = "?" + "page=" + meta.current_page;
			getData("companies", params);
		});

		const getInfo = () => {
			Axios.get("/api/quickbooks/company")
				.then((res) => console.log(res))
				.catch((e) => console.log(e));
		};

		onMounted(() => {
			getData("companies");
		});

		return { companies, meta, getInfo };
	},
});
</script>


<template>
	<div class="table">
		<div class="table__headers">
			<h3>Realm</h3>
			<h3>Name</h3>
		</div>
		<div
			class="table__contents"
			v-for="company in companies"
			:key="company.id"
		>
			<p>{{ company.realm }}</p>
			<button @click="handleQBConnect(company.realm)">
				{{ company.name }}
			</button>
		</div>
	</div>
	<Paginator v-model:meta="meta" />
</template>

<script lang="ts">
import Paginator from "../components/molecules/Paginator.vue";
import { defineComponent, onMounted, ref, reactive, watchEffect } from "vue";
import Axios from "../api";
import QBAxios from "../qb-api";

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
			/* const params = Object.entries(meta).reduce((accum, cv) => { */
			/* 	return accum.concat(cv[0] + "=" + cv[1]); */
			/* }, "?"); */

			const params = "?" + "page=" + meta.current_page;

			getData("companies", params);
		});

		onMounted(() => {
			getData("companies");
		});

		return { companies, meta };
	},
});
</script>


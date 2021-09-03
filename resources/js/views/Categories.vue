<template>
	<div class="categories">
		<select
			v-if="categories.length"
			id="categories"
			name="category"
			v-model="category"
			@change="handleCategoryChange"
			class="categories__select"
		>
			<option v-for="{ id, name } in categories" :value="name" :key="id">
				{{ name }}
			</option>
		</select>

		<div class="data-container">
			<div class="data-container__headers">
				<select
					id="headers"
					name="header"
					multiple
					v-model="tableHeaders"
					:size="headers.length"
					@change="setTableContents"
				>
					<option
						v-for="(header, index) in headers"
						:value="header"
						:key="index"
					>
						{{ header }}
					</option>
				</select>
			</div>

			<div class="data-container__details">
				<div
					class="data-container__details--headers"
					:style="tableStyle"
				>
					<div v-for="header in tableHeaders" :key="header">
						{{ header }}
					</div>
				</div>
				<div
					v-for="(item, index) in tableContents"
					:key="index"
					class="data-container__details--content"
					:style="tableStyle"
				>
					<div v-for="header in tableHeaders" :key="header">
						{{ item[header] }}
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, onMounted, computed, ref } from "vue";
import Axios from "../api";
import { useStore } from "vuex";

export default defineComponent({
	name: "Categories",
	setup() {
		const store = useStore();
		const category = ref("");
		const results = ref([]);
		const headers = ref<string[] | undefined>([]);
		const tableHeaders = ref([]);
		const categories = computed(() => store.getters["getCategories"]);
		const tableContents = ref([]);
		const tableStyle = computed(
			() =>
				`grid-template-columns: repeat(${tableHeaders.value.length}, 1fr)`
		);
		onMounted(() => {
			store.dispatch("getCategories");
		});

		const setTableContents = () => {
			tableContents.value = results.value.map((result) => {
				const obj = {};
				tableHeaders.value.forEach(
					(header) => (obj[header] = result[header])
				);

				return obj;
			});
		};

		const handleCategoryChange = () => {
			Axios.get(`/api/categories/${category.value}`)
				.then((response: any) => {
					const data = response.data[category.value];
					headers.value = Object.keys(data[0])
						.map((key) => {
							if (typeof data[0][key] === "string") {
								return key;
							}
						})
						.filter((i) => i);
					results.value = data;
				})
				.catch((e) => {
					results.value = [];
					console.log(e);
				});
		};

		return {
			categories,
			category,
			handleCategoryChange,
			results,
			headers,
			tableHeaders,
			tableContents,
			setTableContents,
			tableStyle,
		};
	},
});
</script>


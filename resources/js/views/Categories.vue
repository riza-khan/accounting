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

		<div class="data-container" v-if="results.length">
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
				<div>
					<div class="actions" v-if="targetElements.length">
						<button @click="deleteTargetElements">Delete</button>
					</div>
					<Paginator
						:total="total"
						:perPage="perPage"
						:currentPage="currentPage"
						@changeCurrentPage="updateCurrentPage"
						@changePerPage="updatePerPage"
					/>
				</div>
				<div
					class="data-container__details--headers"
					:style="tableStyle"
				>
					<div class="empty">
						<input
							type="checkbox"
							v-model="allCheckbox"
							@input="selectAll($event.target.checked)"
						/>
					</div>
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
					<div>
						<input
							type="checkbox"
							:checked="targetElements.includes(index)"
							@input="selectItem($event.target.checked, index)"
						/>
					</div>
					<div v-for="header in tableHeaders" :key="header">
						<p @click="handleItemClick">
							{{ item[header] }}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, onMounted, computed, ref, watch } from "vue";
import Axios from "../api";
import Paginator from "../components/molecules/Paginator.vue";
import { useStore } from "vuex";

export default defineComponent({
	name: "Categories",
	components: { Paginator },
	setup() {
		const store = useStore();
		const category = ref("");
		const results = ref([]);
		const headers = ref([]);
		const tableHeaders = ref([]);
		const categories = computed(() => store.getters["getCategories"]);
		const tableContents = ref<any[]>([]);
		const tableStyle = computed(
			() =>
				`grid-template-columns: 50px repeat(${tableHeaders.value.length}, 1fr)`
		);

		// Pagination
		const total = ref(0);
		const currentPage = ref(1);
		const perPage = ref(10);

		const updateCurrentPage = (page: number) => {
			currentPage.value = page;
		};

		const updatePerPage = (by: number) => {
			console.log(by);
			perPage.value = by;
		};

		// Table of Contents
		const setTableContents = () => {
			tableContents.value = results.value.map((result) => {
				const obj = {};
				tableHeaders.value.forEach(
					(header) => (obj[header] = result[header])
				);

				return obj;
			});
		};

		const allCheckbox = ref(false);
		const targetElements = ref<number[]>([]);

		const deleteTargetElements = () => {
			const deleteTargets = tableContents.value.filter(
				(item: any, index: number) =>
					targetElements.value.includes(index)
			);

			console.log(deleteTargets);
		};

		const selectAll = (state: boolean) => {
			if (state) {
				targetElements.value = tableContents.value.map(
					(x: any, i: number) => i
				);
			} else {
				targetElements.value = [];
			}
		};

		const selectItem = (state: boolean, index: number) => {
			if (state) {
				targetElements.value.push(index);
			} else {
				targetElements.value = targetElements.value.filter(
					(num) => num !== index
				);
			}
		};

		const handleItemClick = () => {
			console.log("called");
		};

		const handleCategoryChange = () => {
			Axios.post(`/api/categories/${category.value}`, {
				currentPage: +currentPage.value,
				perPage: +perPage.value,
			})
				.then((response: any) => {
					const data = response.data[category.value];
					total.value = response.data.count;
					headers.value = Object.keys(data[0])
						.map((key) => {
							if (typeof data[0][key] === "string") {
								return key;
							}
						})
						.filter((i) => i);
					results.value = data.sort((a: any, b: any) => a.Id - b.Id);
				})
				.catch((e) => {
					results.value = [];
					console.log(e);
				});
		};

		// Mounted
		onMounted(() => {
			store.dispatch("getCategories");
		});

		watch([total, currentPage, perPage], () => handleCategoryChange());
		watch([results], () => {
			setTableContents();
			targetElements.value = [];
			allCheckbox.value = false;
		});

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
			total,
			currentPage,
			perPage,
			updatePerPage,
			updateCurrentPage,
			selectAll,
			selectItem,
			allCheckbox,
			targetElements,
			handleItemClick,
			deleteTargetElements,
		};
	},
});
</script>

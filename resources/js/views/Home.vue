<template>
	<h1>Home</h1>
	<div class="table">
		<div class="table__headers">
			<h3>Make</h3>
			<h3>Model</h3>
			<h3>Year</h3>
		</div>
		<div class="table__contents" v-for="car in cars" :key="car.id">
			<p>{{ car.make }}</p>
			<p>{{ car.model }}</p>
			<p>{{ car.year }}</p>
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import Axios from "../api";

export default defineComponent({
	setup() {
		const cars = ref([]);

		onMounted(() => {
			Axios.get("/api/cars").then(({ data }) => (cars.value = data));
		});

		return { cars };
	},
});
</script>


<template>
	<div class="navbar">
		<router-link :to="{ name: 'Confirm' }">Confirm</router-link>
		<router-link :to="{ name: 'Import' }"
			>Import Excel File to move</router-link
		>
		<button @click="changeCompany">Change Company</button>
	</div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Axios from "../../api";

export default defineComponent({
	setup() {
		const changeCompany = () => {
			Axios.get("/api/quickbooks/connect")
				.then(({ data }) => {
					window.location = data;
				})
				.catch((e) => console.log(e));
		};
		return { changeCompany };
	},
});
</script>


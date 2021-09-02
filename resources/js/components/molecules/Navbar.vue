<template>
	<div class="navbar">
		<router-link :to="{ name: 'Random' }">Random</router-link>
		<router-link :to="{ name: 'Confirm' }">Confirm</router-link>
		<router-link :to="{ name: 'Company' }">Company</router-link>
		<router-link :to="{ name: 'Import' }"
			>Import Excel File to move</router-link
		>
		<button @click="handleQBConnect">Connect To QuickBooks</button>
	</div>
</template>

<script lang="ts">
import Axios from "../../api";
import { defineComponent } from "vue";

export default defineComponent({
	setup() {
		const handleQBConnect = () => {
			Axios.get("/api/quickbooks/connect")
				.then(({ data }) => {
					window.location = data;
				})
				.catch((e) => console.log(e));
		};

		return { handleQBConnect };
	},
});
</script>


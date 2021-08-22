<template>
	<div class="navbar">
		<router-link :to="{ name: 'Home' }">Dashboard</router-link>
		<router-link :to="{ name: 'Import' }">Import Excel File</router-link>
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
					console.log(data);
					window.open(data);
				})
				.catch((e) => console.log(e));
		};
		return { handleQBConnect };
	},
});
</script>


<template>
	<div class="navbar">
		<div class="navbar__links">
			<router-link :to="{ name: 'Information' }">Information</router-link>
			<router-link :to="{ name: 'Import' }">Import Documents</router-link>
		</div>
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


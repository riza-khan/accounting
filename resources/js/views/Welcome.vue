<template>
	<h1>Welcome page</h1>
	<button class="btn-success-sm" @click="handleClick">Click me</button>
</template>

<script lang="ts">
import Axios from "../api";
import { defineComponent } from "vue";

export default defineComponent({
	setup() {
		const handleClick = async () => {
			const response = await Axios.get("/api/stuff");
			console.log(response);
		};
		return { handleClick };
	},
});
</script>


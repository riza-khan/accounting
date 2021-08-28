<template>
	<button @click="handleConfirm">Confirm</button>
</template>

<script lang="ts">
import Axios from "../api";
import { defineComponent } from "vue";
import { useRoute, useRouter } from "vue-router";

export default defineComponent({
	setup() {
		const route = useRoute();
		const router = useRouter();

		const handleConfirm = () => {
			Axios.post("/api/quickbooks/connect", {
				...route.query,
			})
				.then(() => router.push({ name: "Home" }))
				.then((e: any) => console.log(e));
		};

		return { handleConfirm };
	},
});
</script>


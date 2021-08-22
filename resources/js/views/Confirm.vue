<template>
	<button @click="handleConfirm">Confirm</button>
</template>

<script lang="ts">
import Axios from "../api";
import { defineComponent, ref } from "vue";
import { useRoute } from "vue-router";

export default defineComponent({
	setup() {
		const route = useRoute();

		const handleConfirm = () => {
			Axios.post("/api/quickbooks/connect", {
				...route.query,
			})
				.then((res: any) => console.log(res))
				.then((e: any) => console.log(e));
		};

		return { handleConfirm };
	},
});
</script>


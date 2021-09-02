<template>
	<h2>Import File:</h2>
	<form action="/" @submit.prevent="handleFileImport">
		<label for="file">Choose an Excel File</label>
		<input
			type="file"
			id="file"
			accept=".xlsx, .xls, .csv"
			name="file"
			@change="handleFileAdded"
		/>
		<button>Upload</button>
	</form>
</template>

<script lang="ts">
import Axios from "../api";
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";

export default defineComponent({
	setup() {
		const router = useRouter();
		const file = ref<string | Blob>("");

		const handleFileAdded = (e: any) => {
			const target = e.dataTransfer || e.target;

			if (!target.files) {
				return;
			}

			file.value = target.files[0];
		};

		const handleFileImport = (e: HTMLFormElement) => {
			const formData = new FormData();
			formData.append("file", file.value);
			Axios.post("/api/invoice-import", formData, {
				headers: {
					"Content-Type": "multipart/form-data",
				},
			});
			router.push({ name: "Dashboard" });
		};

		return { handleFileImport, handleFileAdded };
	},
});
</script>

<template>
	<form action="/" @submit.prevent="handleFileImport($event, category)">
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
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";
import Axios from "../../api";

export default defineComponent({
	props: {
		category: {
			type: Object,
			default: () => ({}),
		},
	},
	setup(props) {
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
			Axios.post(
				`/api/${props.category.name.toLowerCase()}/import`,
				formData,
				{
					headers: {
						"Content-Type": "multipart/form-data",
					},
				}
			)
				.then(() => {
					router.push({ name: "Import" });
				})
				.catch((e: any) => console.log(e));
		};
		return { handleFileImport, handleFileAdded };
	},
});
</script>

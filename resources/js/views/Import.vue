<template>
	<h2>Import File:</h2>
	<form action="/">
		<label for="file">Choose an Excel File</label>
		<input type="file" id="file" accept=".xlsx, .xls, .csv" />
		<button>Upload</button>
	</form>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
	setup() {
		return {};
	},
});
</script>

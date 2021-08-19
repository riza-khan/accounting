<template>
	<router-view />
	<pre>{{ user }}</pre>
</template>

<script lang="ts">
import { defineComponent, Prop } from "vue";

export default defineComponent({
	props: {
		user: {
			type: Object,
			required: true,
		},
	},
	setup() {
		return {};
	},
});
</script>


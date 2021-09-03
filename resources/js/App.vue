<template>
	<Loader />
	<router-view />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Loader from "./components/molecules/Loader.vue";

export default defineComponent({
	components: { Loader },
	setup() {
		return {};
	},
});
</script>


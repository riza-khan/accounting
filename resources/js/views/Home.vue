<template>
	<h1>Home page</h1>
	{{ state }}
	<router-link :to="{ name: 'Welcome' }">Welcome page</router-link>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { useStore } from "vuex";

export default defineComponent({
	setup() {
		const store = useStore();

		const state = computed(() => store.getters["getLoading"]);

		return { state };
	},
});
</script>


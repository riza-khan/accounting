<template>
	<div class="loader" v-if="loader">
		<div class="loader__item">Loading...</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { useStore } from "vuex";

export default defineComponent({
	setup() {
		const store = useStore();
		const loader = computed(() => store.getters["getLoader"]);

		return { loader };
	},
});
</script>


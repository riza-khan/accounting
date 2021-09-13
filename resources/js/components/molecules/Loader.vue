<template>
	<div class="loader-container" v-if="loader">
		<div class="loader-container__loader"></div>
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

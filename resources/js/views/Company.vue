<template>
	<h3>{{ companyName }}</h3>
	<Navbar />
	<router-view />
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import Navbar from "../components/molecules/Navbar.vue";
import { useStore } from "vuex";

export default defineComponent({
	name: "Company",
	components: { Navbar },
	setup() {
		const store = useStore();
		const companyName = computed(() => store.getters["getCompanyName"]);

		return {
			companyName,
		};
	},
});
</script>


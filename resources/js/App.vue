<template>
	<Navbar />
	<router-view />
</template>

<script lang="ts">
import Navbar from "./components/molecules/Navbar.vue";
import { defineComponent } from "vue";

export default defineComponent({
	components: { Navbar },
	setup() {
		return {};
	},
});
</script>


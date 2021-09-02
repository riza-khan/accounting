<template>
	<h3>Company</h3>
	<Navbar />
	<router-view />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Navbar from "../components/molecules/Navbar.vue";

export default defineComponent({
	name: "Company",
	components: { Navbar },
	setup() {
		return {};
	},
});
</script>


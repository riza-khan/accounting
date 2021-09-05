<template>
	<Loader />
	<Modal />
	<router-view />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Loader from "./components/molecules/Loader.vue";
import Modal from "./components/molecules/Modal.vue";

export default defineComponent({
	components: { Loader, Modal },
	setup() {
		return {};
	},
});
</script>

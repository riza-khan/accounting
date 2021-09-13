<template>
	<Loader></Loader>
	<Modal></Modal>
	<router-view></router-view>
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue";
import { useStore } from 'vuex'
import Loader from "./components/molecules/Loader.vue";
import Modal from "./components/molecules/Modal.vue";

export default defineComponent({
	components: { Loader, Modal },
	setup() {
        const store = useStore()

        onMounted(() => {
            store.dispatch('getCategories')
        })

		return {};
	},
});
</script>

<template>
	<div class="modal" v-if="objHasProperties">
		<div class="modal__body">
			<div class="modal__body--close">
				<button @click="handleCloseClick">Close</button>
			</div>
			<div class="modal__body--content">
				<div
					v-for="(property, index) in Object.keys(obj)"
					:key="index"
					class="modal__body--content--item"
				>
					<strong>{{ property }}:</strong>
					<p>{{ obj[property] }}</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { useStore } from "vuex";
import { isEmpty } from "lodash";

export default defineComponent({
	setup() {
		const store = useStore();
		const obj = computed(() => store.getters["getModalTargetObj"]);
		const objHasProperties = computed(() => !isEmpty(obj.value));

		const handleCloseClick = () => {
			store.commit("setModalTargetObj", {});
		};

		return { obj, handleCloseClick, objHasProperties };
	},
});
</script>

<template>
	<div class="paginator">
		<div
			v-for="page in numOfPages"
			:key="page"
			@click="meta.current_page = page"
			:class="meta.current_page === page ? 'paginator--current_page' : ''"
		>
			{{ page }}
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";

export default defineComponent({
	name: "Paginator",
	props: {
		meta: {
			type: Object,
			default: () => ({}),
		},
	},
	setup(props, { emit }) {
		const numOfPages = computed(() =>
			Math.ceil(props.meta.total / props.meta.per_page)
		);
		return { numOfPages, emit };
	},
});
</script>


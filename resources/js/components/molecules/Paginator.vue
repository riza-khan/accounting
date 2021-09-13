<template>
	<div class="paginator">
		<select @change="emit('changePerPage', $event.target.value)">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="1000">1000</option>
		</select>
		<div class="paginator__numbers">
			<button
				v-for="page in numOfPages"
				:key="page"
				@click="emit('changeCurrentPage', page)"
				:class="currentPage === page ? 'paginator--current_page' : ''"
			>
				{{ page }}
			</button>
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";

export default defineComponent({
	name: "Paginator",
	props: {
		total: {
			type: Number,
			default: 0,
		},
		perPage: {
			type: Number,
			default: 0,
		},
		currentPage: {
			type: Number,
			default: 0,
		},
	},
	setup(props, { emit }) {
		const numOfPages = computed(() =>
			Math.ceil(props.total / props.perPage)
		);
		return { numOfPages, emit };
	},
});
</script>

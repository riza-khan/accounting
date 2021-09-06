<template>
	<div class="uploads">
		<div class="uploads__content">
			<div
				class="uploads__content--card"
				v-for="category in categories"
				:key="category"
			>
				<h3 class="uploads__content--card--title">
					{{ category.name }}
				</h3>
				<div class="uploads__content--card--left">
					<Uploader :category="category" />
				</div>
				<div class="uploads__content--card--right">
					<div class="uploads__content--card--right--body">
						<p>
							Lorem ipsum dolor sit amet consectetur adipisicing
							elit. Et deserunt necessitatibus ullam temporibus
							tenetur facere corporis aut nihil repellat maiores,
							recusandae voluptas nulla odio eos, quidem debitis,
							alias dolores at.
						</p>
					</div>

					<div class="uploads__content--card--right--actions">
						<button @click="handlePushToQuickbooks(category)">
							Push to Quickbooks
						</button>
						<button @click="handlePushToQuickbooks(category)">
							Delete from Quickbooks
						</button>
						<button @click="handlePushToQuickbooks(category)">
							Something else to Quickbooks
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { useStore } from "vuex";
import Axios from "../api";
import Uploader from "../components/molecules/Uploader.vue";

export default defineComponent({
	components: { Uploader },
	setup() {
		const store = useStore();
		const categories = computed(() => store.getters["getCategories"]);

		const handlePushToQuickbooks = (category: string) => {
			Axios.get("/api/upload-invoices")
				.then((res: any) => console.log(res))
				.catch((e: any) => console.log(e));
		};

		return { categories, handlePushToQuickbooks };
	},
});
</script>

<template>
	<div class="modal">
		<pre>{{ obj }}</pre>
	</div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import {useStore} from 'vuex'

export default defineComponent({
	props: {
		obj: {
			type: Object,
			default: () => ({}),
		},
	},
	setup() {
		return {};
	},
});
</script>


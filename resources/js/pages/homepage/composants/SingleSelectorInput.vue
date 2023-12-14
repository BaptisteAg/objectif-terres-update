<template>
	<div class="is-flex is-flex-direction-column is-justify-content-space-between">
		<div class="mb-3">{{ label }}</div>
		<b-dropdown v-model="selectedOption" expanded aria-role="list">
			<template #trigger="{ active }">
				<b-button
					:label="optionLabels[selectedOption] || 'Sélectionnez une catégorie'"
					:icon-right="active ? 'menu-up' : 'menu-down'"/>
			</template>
			<b-dropdown-item aria-role="listitem" :value="category"
							 v-for="(labelOption, category) of optionLabels"
							 :key="category">
				{{ labelOption }}
			</b-dropdown-item>
		</b-dropdown>
	</div>
</template>
<script>
export default {
	name: "AdvancedSearchHome",
	props: {
		label: {
			type: String,
			default: ''
		},
		optionLabels: {
			required: true
		},
		value: {
			type: String,
			required: true
		}
	},
	data() {
		return {
			selectedOption: this.value
		}
	},
	watch: {
		selectedOption() {
			this.$emit('input', this.selectedOption)
		}
	}
}
</script>

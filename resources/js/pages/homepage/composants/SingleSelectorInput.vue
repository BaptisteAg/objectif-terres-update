<template>
	<div class="is-flex is-flex-direction-column is-justify-content-space-between">
		<div class="mb-3">{{ label }}</div>
		<b-dropdown v-model="selectedOption" expanded aria-role="list">
			<template #trigger="{ active }">
				<b-button
					:label="options.find(o => o.id === selectedOption)?.name || 'Sélectionnez une catégorie'"
					:icon-right="active ? 'menu-up' : 'menu-down'"/>
			</template>
			<b-dropdown-item aria-role="listitem"
							 v-for="(option, key) of options"
                             :value="option.id"
							 :key="key">
				{{ option.name }}
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
		options: {
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

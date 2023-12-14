<template>
	<div class="is-flex is-flex-direction-column is-justify-content-space-between">
		<div class="mb-3">{{ label }}</div>

		<b-dropdown :disabled="conditionDisabled" expanded
					v-model="selectedOptions" aria-role="list" class="mb-3"
					multiple>
			<template #trigger="{ active }">
				<b-button
					:label="getSelectedLabel()"
					:icon-right="active ? 'menu-up' : 'menu-down'"/>
			</template>

			<b-dropdown-item
				v-if="hasToggleAll"
				aria-role="listitem"
				@click="toggleAll"
				:value="-1">
				Toute {{ this.selectedOptions.length === this.listOptions.length ? 'déséléctionner' : 'séléctionner' }}
			</b-dropdown-item>
			<b-dropdown-item v-if="hasToggleAll" separator></b-dropdown-item>

			<b-dropdown-item v-for="(option, index) in listOptions" :key="index"
							 aria-role="listitem"
							 :value="option.id">
				{{ option.name }}
			</b-dropdown-item>
		</b-dropdown>

		<b-taglist v-if="haveTags">
			<b-tag
				v-for="(option,index) in selectedOptions"
				:key="index"
				rounded
				closable
				@close="removeSelectedOption(option)"
			>
				{{ getOptionById(option).name }}
			</b-tag>
		</b-taglist>
	</div>
</template>

<script>
export default {
	name: "MultipleSelector",
	props: {
		label: {
			type: String,
			default: ''
		},
		conditionDisabled: {
			type: Boolean,
			default: false
		},
		listOptions: {
			type: Array,
			required: true
		},
		value: {
			type: Array,
			default: () => []
		},
		haveTags: {
			type: Boolean,
			default: false
		},
		hasToggleAll: {
			type: Boolean,
			default: false
		},
		unitLabel: {
			type: String,
			default: 'option'
		},
		unitLabelGender: {
			type: String,
			default: 'f'
		}
	},
	data() {
		return {
			selectedOptions: this.value
		}
	},
	methods: {
		getSelectedLabel() {
			if (!this.selectedOptions.length) return 'Sélectionnez un' + (this.unitLabelGender === 'f' ? 'e' : '') + ' ' + this.unitLabel;
			if (this.selectedOptions.length === this.listOptions.length) return 'Tou' + (this.unitLabelGender === 'f' ? 'te' : '') + 's les ' + this.unitLabel + 's';
			return this.selectedOptions.map(id => this.listOptions.find(listOption => listOption.id === id).name).join(', ');
		},
		removeSelectedOption(option) {
			this.selectedOptions = this.selectedOptions.filter(o => o !== option);
		},
		getOptionById(id) {
			return this.listOptions.find(listOption => listOption.id === id);
		},
		toggleAll() {
			this.selectedOptions = this.selectedOptions.length === this.listOptions.length + 1 ? [] : [...this.listOptions.map(listOption => listOption.id)];
		},
	},
	watch: {
		selectedOptions(newOption) {
			this.$emit('input', newOption);
		}
	}
};
</script>

<template>
	<div class="columns">
		<div class="column">
			<b-dropdown size="is-medium" v-model="dropdownValue" expanded aria-role="list" class="mb-3"
						:multiple="!isUnique" :close-on-click="isUnique">
				<template #trigger="{ active }">
					<b-button
						:label="label"
						:icon-right="active ? 'menu-up' : 'menu-down'"/>
				</template>

				<b-dropdown-item v-for="(option, index) in options"
								 :key="index"
								 :value="option.id"
								 aria-role="listitem">
					{{ option.name }}
				</b-dropdown-item>
			</b-dropdown>
			<slot></slot>
		</div>
		<div class="column" v-if="!this.isUnique">
			<b-taglist>
				<b-tag
					v-for="(selectedOption,index) in selectedOptions"
					:key="index"
					rounded
					size="is-medium"
					type="is-primary"
					closable
					@close="remove(selectedOption)"
				>
					{{ selectedOption.name }}
				</b-tag>
			</b-taglist>
		</div>
		<input v-for="selectedOption in selectedOptions" type="hidden" :name="name"
			   :value="selectedOption.id">
	</div>
</template>
<script>
export default {
	props: {
		isInputDisabled: {
			type: Boolean,
		},
		name: String,
		options: {
			type: Array,
			required: true
		},
		value: {
			type: [String, Array],
			required: true
		},
		isUnique: {
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
		},
	},
	data() {
		return {
			dropdownValue: (this.isUnique ?
					this.options.find(o => o.id === this.value[0])?.id :
					this.options.filter(o => this.value.includes(o.id)).map(o => o.id)
			)
		}
	},
	watch: {
		/** @param {Array|Object} val */
		dropdownValue(val) {
			if (this.isUnique) {
				this.$emit('input', [val]);
				return;
			}
			this.$emit('input', val);
		}
	},
	methods: {
		remove(option) {
			if (Array.isArray(this.dropdownValue)) {
				this.dropdownValue = this.dropdownValue.filter(id => id !== option.id);
				return;
			}
			this.dropdownValue = [];
		},
	},
	computed: {
		selectedOptions() {
			let ids;
			if (Array.isArray(this.dropdownValue)) {
				ids = this.dropdownValue
			} else if (this.dropdownValue) {
				ids = [this.dropdownValue];
			} else {
				return [];
			}
			return this.options.filter(option => ids.includes(option.id))
		},
		label() {
			if (this.selectedOptions.length === 0) {
				return 'Sélectionner un' + (this.unitLabelGender === 'f' ? 'e' : '') + ' ' + this.unitLabel
			} else if (this.selectedOptions.length === 1) {
				return this.selectedOptions[0].name
			} else {
				return this.selectedOptions.length + ' ' + this.unitLabel + (this.selectedOptions.length > 1 ? 's' : '') + ' sélectionné' + (this.unitLabelGender === 'f' ? 'e' : '') + 's'
			}
		},
	},
}
</script>

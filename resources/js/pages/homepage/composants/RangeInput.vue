<template>
	<div class="is-flex is-flex-direction-column is-justify-content-space-between">
		<div class="mb-3">{{ label }}</div>
		<div class="columns is-flex-wrap-wrap">
			<div class="column">
				<b-field :type="error ? 'is-danger' : ''">
					<b-input v-model="range.min" :placeholder="placeholder[0]" rounded></b-input>
				</b-field>
			</div>
			<div class="column">
				<b-field :type="error ? 'is-danger' : ''">
					<b-input v-model="range.max" :placeholder="placeholder[1]" rounded></b-input>
				</b-field>
			</div>
			<div class="column is-full" v-if="error">
				<p class="is-danger">La valeur minimale doit être inférieure à la valeur
					maximale</p>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: "RangeInput",
	props: {
		error: {
			type: Boolean,
			default: false
		},
		label: {
			type: String,
			default: ''
		},
		placeholder: {
			type: Array,
			default: function() {
				return ['Minimum', 'Maximum'];
			},
		},
		value: {
			type: Object,
			required: true
		}
	},
	data() {
		return {
			range: {
				min: this.value.min,
				max: this.value.max
			}
		}
	},
	watch: {
		range: {
			handler() {
				this.$emit('input', this.range);
			},
			deep: true
		}
	}
}
</script>

import Autocomplete from '../../components/Autocomplete'
import Vue from 'vue'

Vue.component('user-form', {
	components: {
		Autocomplete,
	},
	props: {
		oldValues: {
			type: Object
		},
	},
	data() {
		return {
			optionProfileSelected: JSON.parse(this.oldValues.profile) || '',
			optionHasFormationSelected: this.oldValues.formation !== null ? '1' : '0',
			formationSelected: JSON.parse(this.oldValues.formation),
			citySelect: this.oldValues.citySelect ? JSON.parse(this.oldValues.citySelect) : [],
			countrySelect: this.oldValues.countrySelect ? JSON.parse(this.oldValues.countrySelect) : [],
			isPasswordToChange: false,
		}
	},
	methods: {
		show_password_inputs() {
			this.isPasswordToChange = this.isPasswordToChange !== true;
		}
	},
	mounted() {
		console.log(this.oldValues)
	}
});

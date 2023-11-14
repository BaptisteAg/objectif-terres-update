import {maxLength, maxValue, minLength, required, decimal} from 'vuelidate/lib/validators'
import baseValidations from './base-validations'

import FormNewAdMixin from "./mixins/form-new-ad-mixin";

import TextAreaCounter from "../../../components/TextAreaCounter";
import Autocomplete from '../../../components/Autocomplete'
import MultiSelect from "../../../components/MultiSelect";
import DocumentsUpload from "../../../components/DocumentsUpload"
import CustomCheckbox from "../../../components/CustomCheckbox"
import ZoneSelect from '../../../components/ZoneSelect'
import ListSelect from "../../../components/ListSelect"

const numberNormalizer = function (inputName) {
	return function (v) {
		if (!v) {
			return;
		}
		v = v.toString().replace(",", ".");

		this.formInput[inputName] = v;
	};
};

export default {
	components: {
		TextAreaCounter,
		Autocomplete,
		MultiSelect,
		DocumentsUpload,
		CustomCheckbox,
		ZoneSelect,
		ListSelect,
	},
	mixins: [FormNewAdMixin],
	props: {},
	data() {
		let old = this.oldValues;

		if (!old.associate_offer) {
			old.associate_offer = {}
		}

		return {
			formInput: {
				selectedDepartments: old.selected_departments && JSON.parse(old.selected_departments) || [],
				selectedZones: old.selected_zones && JSON.parse(old.selected_zones) || [],

				acceptUseZipCode: old.associate_offer.accept_use_zip_code,
				surface: old.associate_offer.surface || '',
				altitude: old.associate_offer.altitude || '',
				waterAccess: typeof old.associate_offer.water_access !== "undefined" ?
					old.associate_offer.water_access : '',
				hasBuildings: old.associate_offer.has_buildings,
				hasHouses: old.associate_offer.has_houses,
				productionGenres: old.associate_offer.production_genres || [],
				productionGenresSecondary: old.associate_offer.secondary_production_genres || [],
				bioCertifications: old.associate_offer.bio_certifications || [],

				associateDescription: old.associate_offer.associate_description || '',
				experienceFarming: old.associate_offer.experience_farming || '',
				aboutProject: old.about_project_content || '',
				isActivityTransmission: old.associate_offer.is_activity_transmission,
				educationLevels: old.associate_offer.education_levels || [],

				chartConfirmation: old.chart_confirmation || true,
				aboutContent: old.about_content || '',
				title: old.title || '',
				documents: old.documents && JSON.parse(old.documents) || [],
			}
		};
	},
	computed: {
		productionGenresHasOther() {
			return this.formInput.productionGenres.includes('other');
		},
		productionGenresSecondaryHasOther() {
			return this.formInput.productionGenresSecondary.includes('other');
		},
		hasWaterAccess() {
			return this.formInput.waterAccess && this.formInput.waterAccess.toString() === "1";
		}
	},
	watch: {
		'formInput.surface': numberNormalizer('surface'),
		'formInput.altitude': numberNormalizer('altitude'),
	},
	validations() {

		return {
			formInput: {
				...baseValidations.formInput,
				selectedDepartments: {
					hasZone(zones) {
						return zones.length;
					}
				},
				selectedZones: {
					hasZone(zones) {
						return zones.length;
					}
				},
				bioCertifications: {
					required(values) {
						return values.length;
					}
				},
				surface: {
					required,
					decimal,
					maxValue: maxValue(1000)
				},
				educationLevels: {
					required
				},
				hasHouses: {required},
				hasBuildings: {required},
				productionGenres: {
					required(values) {
						return values.length;
					}
				},
				waterAccess: {required},
				altitude: {
					decimal,
					//required
				},
				associateDescription: {
					required,
					minLength: minLength(5),
					maxLength: maxLength(1500),
				},
				chartConfirmation: {
					required,
					isTrue: value => value === true
				},
				aboutContent: {
					minLength: minLength(5),
					maxLength:
						maxLength(1000),
				},
			}
		}
	}
};

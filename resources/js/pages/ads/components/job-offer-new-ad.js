import {maxLength, minLength, numeric, required, requiredIf} from 'vuelidate/lib/validators'
import baseValidations from './base-validations'

import FormNewAdMixin from "./mixins/form-new-ad-mixin";

import TextAreaCounter from "../../../components/TextAreaCounter";
import CustomCheckbox from "../../../components/CustomCheckbox"
import Autocomplete from '../../../components/Autocomplete'
import DocumentsUpload from "../../../components/DocumentsUpload"
import MultiSelect from "../../../components/MultiSelect";
import ZoneSelect from '../../../components/ZoneSelect';
import ListSelect from "../../../components/ListSelect.vue";

export default {
	components: {
		TextAreaCounter,
		CustomCheckbox,
		Autocomplete,
		DocumentsUpload,
		MultiSelect,
		ZoneSelect,
		ListSelect
	},
	mixins: [FormNewAdMixin],
	props: {},
	data() {
		const v = this.oldValues;
		const hasOld = Object.keys(v).length && v.job_offer;

		return {
			formInput: {
				selectedDepartments: hasOld && JSON.parse(v.selected_departments) || [],
				selectedZones: hasOld && JSON.parse(v.selected_zones) || [],

				offerTypes: hasOld && v.job_offer.offer_types || [],
				productionGenres: hasOld && v.job_offer.production_genres || [],
				productionGenresSecondary: hasOld && v.job_offer.secondary_production_genres || [],
				isActivityTransmission: hasOld && v.job_offer.is_activity_transmission || undefined,
				jobDescription: hasOld && v.job_offer.job_description || '',
				experienceFarming: hasOld && v.job_offer.experience_farming || '',
				educationLevels: hasOld && v.job_offer.education_levels || [],

				aboutProject: hasOld && v.about_project_content || '',
				aboutContent: hasOld && v.about_content || '',
				title: hasOld && v.title || '',
				documents: hasOld && JSON.parse(v.documents) || [],
				chartConfirmation: hasOld && v.chart_confirmation || false,
				//beneficiary: hasOld ? v.is_beneficiary : '',
				//agriculturalActivity: hasOld ? v.agricultural_activity || [],
			}
		}
	},
	watch: {},
	validations() {
		return {
			formInput: {
				...baseValidations.formInput,
				jobDescription: {
					required,
					minLength: minLength(5),
					maxLength: maxLength(1000)
				},
				isActivityTransmission: {
					required
				},
				experienceFarming: {
					//required,
					minLength: minLength(5),
					maxLength: maxLength(1000)
				},
				offerTypes: {required},
				documents: {
					oneDocument: _ => true,
					notCurrentlyUploading: baseValidations.formInput.documents.notCurrentlyUploading
				},
				selectedZones: {
					required
				},
				educationLevels: {
					required
				},
				productionGenres: {
					required
				},
				chartConfirmation: {
					required,
					isTrue: value => value === true
				},
			}
		}
	}
};

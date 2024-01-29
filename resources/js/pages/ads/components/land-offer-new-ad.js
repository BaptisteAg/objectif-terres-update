import {decimal, maxLength, maxValue, minLength, required, requiredIf} from 'vuelidate/lib/validators'
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

		if (!old.land_offer) {
			old.land_offer = {}
		}

		return {
			formInput: {
				selectedDepartments: old.selected_departments && JSON.parse(old.selected_departments) || [],
				selectedZones: old.selected_zones && JSON.parse(old.selected_zones) || [],

				acceptUseZipCode: old.land_offer.accept_use_zip_code,
				surface: old.land_offer.surface || '',
				sauDescription: old.land_offer.sau_description || '',
				productionGenres: old.land_offer.production_genres || [],
				productionGenresSecondary: old.land_offer.secondary_production_genres || [],
				bioCertifications: old.land_offer.bio_certifications || [],
				waterAccess: typeof old.land_offer.water_access !== "undefined" ?
					old.land_offer.water_access : '',
				waterAccessDescription: old.land_offer.water_access_description || '',
				altitude: old.land_offer.altitude || '',

				hasBuildings: typeof old.land_offer.has_buildings !== 'undefined' ? old.land_offer.has_buildings : '',
				buildingDescription: old.land_offer.building && old.land_offer.building.description || '',
				hasHouses: typeof old.land_offer.has_houses !== 'undefined' ? old.land_offer.has_houses : '',
				houseDescription: old.land_offer.house && old.land_offer.house.description || '',

				offerGenres: old.land_offer.offer_genres || [],
				price: old.land_offer.price || '',
				isSaleOfferEvaluation: old.land_offer.is_sales_offer_evaluation,
				rentPrice: old.land_offer.rent_price || '',
				testDescription: old.land_offer.test_description || '',
				chartConfirmation: old.chart_confirmation || true,

				aboutProject: old.about_project_content || '',
				aboutContent: old.about_content || '',
				title: old.title || '',
				documents: old.documents && JSON.parse(old.documents) || [],

				//confirmPriceFermage: hasOld ? !!v.confirm_price_fermage : false,

				//...extraFormInput
			},
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
		},
		isSaleOffer() {
			return this.formInput.offerGenres.find(offerGenreId => offerGenreId.toString() === "1");
		},
		isRentOffer() {
			return this.formInput.offerGenres.find(offerGenreId => offerGenreId.toString() === "2");
		},
		isTestOffer() {
			return this.formInput.offerGenres.find(offerGenreId => offerGenreId.toString() === "3");
		},
	},
	methods: {
		choiceOfferGenres(value) {
			if (value.includes('1') || value.includes(1)) {
				if (this.oldValues.land_offer && this.oldValues.land_offer.price) {
					this.formInput.price = this.oldValues.land_offer.price
				}
			} else {
				this.formInput.price = ''
			}
			if (value.includes('2') || value.includes(2)) {
				if (this.oldValues.land_offer && this.oldValues.land_offer.rent_price) {
					this.formInput.rentPrice = this.oldValues.land_offer.rent_price
				}
			} else {
				this.formInput.rentPrice = ''
			}
		}
	},
	mounted() {
		this.choiceOfferGenres(this.formInput.offerGenres);
	},
	watch: {
		'formInput.surface': numberNormalizer('surface'),
		'formInput.altitude': numberNormalizer('altitude'),
		'formInput.price': numberNormalizer('price'),
		'formInput.rentPrice': numberNormalizer('rentPrice'),
		'formInput.offerGenres': function (value) {
			this.choiceOfferGenres(value);
		}
	},
	validations() {
		return {
			formInput: {
				...baseValidations.formInput,
				selectedDepartments: {
					hasDepartment(departments) {
						return departments.length;
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
				sauDescription: {
					minLength: minLength(5),
					maxLength: maxLength(1000),
				},
				hasHouses: {required},
				hasBuildings: {required},
				productionGenres: {
					required(values) {
						return values.length;
					}
				},
				waterAccess: {required},
				waterAccessDescription: {
					minLength: minLength(4),
					maxLength: maxLength(200),
				},
				altitude: {
					decimal,
					//required
				},
				offerGenres: {required},
				price: {
					required: requiredIf(() => {
						return Object.values(this.formInput.offerGenres).includes('1') && !this.formInput.isSaleOfferEvaluation
					}),
					decimal,
				},
				rentPrice: {
					decimal,
					required: requiredIf(() => {
						return Object.values(this.formInput.offerGenres).includes('2')
					})
				},
				testDescription: {
					minLength: minLength(5),
					maxLength: maxLength(1000),
					required: requiredIf(() => {
						return Object.values(this.formInput.offerGenres).includes('3')
					})
				},
				chartConfirmation: {
					required,
					isTrue: value => value === true
				},

				buildingDescription: {
					minLength: minLength(5),
					maxLength: maxLength(1000),
				},

				houseDescription: {
					minLength: minLength(5),
					maxLength: maxLength(1000),
				},

				aboutContent: {
					minLength: minLength(5),
					maxLength:
						maxLength(1000),
				},

				//...extraValidations
			}
		}
	}
};

import {maxLength, maxValue, minLength, required, decimal } from 'vuelidate/lib/validators'
import baseValidations from './base-validations'

import FormNewAdMixin from "./mixins/form-new-ad-mixin";

import TextAreaCounter from "../../../components/TextAreaCounter";
import Autocomplete from '../../../components/Autocomplete'
import MultiSelect from "../../../components/MultiSelect";
import DocumentsUpload from "../../../components/DocumentsUpload"
import CustomCheckbox from "../../../components/CustomCheckbox"

const numberNormalizer = function (inputName) {
    return function (v) {
        if(!v) {
            return;
        }
        v = v.replace(",",".");

        this.formInput[inputName] = v;
    };
};

export default {
    components: {
        TextAreaCounter,
        Autocomplete,
        MultiSelect,
        DocumentsUpload,
        CustomCheckbox
    },
    mixins: [FormNewAdMixin],
    props: {},
    data() {
        let v = this.oldValues;

        if(!v.land_offer) {
            v.land_offer = {}
        }

        const extraFormInput = this.isSupportRequest ? {
            isBeneficiary: v.land_offer.is_beneficiary || '1',
            isActivityTransfer: typeof v.land_offer.is_activity_transfer !== "undefined" ?
                v.land_offer.is_activity_transfer.toString() : '',

            buildingSurface: v.land_offer.building && v.land_offer.building.surface || '',
            buildingOfferGenres: v.land_offer.building && v.land_offer.building.offer_genres || [],

            houseSurface: v.land_offer.house && v.land_offer.house.surface || '',
            houseOfferGenres: v.land_offer.house && v.land_offer.house.offer_genres || [],

            supportRequestText: v.support_request_text || ''
        } : {};

        return  {
            formInput: {
                selectedZones: v.selected_zones && JSON.parse(v.selected_zones) || [],

                surface: v.land_offer.surface || '',
                sauDescription: v.land_offer.sau_description || '',
                productionGenres: v.land_offer.production_genres || [],
                productionGenresWanted: v.land_offer.production_genres_wanted || [],
                bioCertifications: v.land_offer.bio_certifications || [],
                waterAccess: typeof v.land_offer.water_access !== "undefined" ?
                    v.land_offer.water_access : '',
                waterAccessDescription: v.land_offer.water_access_description|| '',
                altitude: v.land_offer.altitude|| '',

                hasBuildings: v.land_offer.has_buildings ? v.land_offer.has_buildings.toString() : '',
                buildingDescription : v.land_offer.building && v.land_offer.building.description|| '',
                hasHouses: v.land_offer.has_houses ? v.land_offer.has_houses.toString() : '',
                houseDescription : v.land_offer.house && v.land_offer.house.description || '',

                offerGenres: v.land_offer.offer_genres || [],
                price: v.land_offer.price || '',
                rentPrice: v.land_offer.rentPrice || '',
                testDescription : v.land_offer.test_description || '',
                chartConfirmation: v.chart_confirmation || false,

                aboutProject: v.about_project_content || '',
                aboutContent: v.about_content || '',
                title: v.title || '',
                documents: v.documents && JSON.parse(v.documents) || [],

                //confirmPriceFermage: hasOld ? !!v.confirm_price_fermage : false,

                ...extraFormInput
            }
        };
    },
    computed: {
        productionGenresHasOther() {
            return this.formInput.productionGenres.includes('other');
        },
        productionGenresWantedHasOther() {
            return this.formInput.productionGenresWanted.includes('other');
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
        }
    },
    methods: {

    },
    watch: {
        'formInput.surface': numberNormalizer('surface'),
        'formInput.altitude': numberNormalizer('altitude'),
        'formInput.price': numberNormalizer('price'),
        'formInput.rentPrice': numberNormalizer('rentPrice'),
    },
    validations() {
        const extraValidations = this.isSupportRequest ? {
            //isBeneficiary: {required},
            isActivityTransfer: {required},

            buildingSurface: {
                decimal
            },
            //buildingOfferGenres: {required},

            houseSurface: {
                decimal
            },
            //houseOfferGenres: {required},

            supportRequestText: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(400),
            }

        } : {};

        return {
            formInput: {
                ...baseValidations.formInput,
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
                productionGenres: {
                    required(values) {
                        return values.length;
                    }
                },
                productionGenresWanted: {},
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
                    decimal,
                    required(v) {
                        return this.isSaleOffer && !this.isSupportRequest ? !!v : true
                    }
                },
                rentPrice: {
                    decimal,
                    /*required(v) {
                        return this.isRentOffer ? !!v : true
                    }*/
                },
                testDescription: {
                    minLength: minLength(5),
                    maxLength: maxLength(1000),
                },
                chartConfirmation: {
                    checked(v) {
                        return !!v
                    }
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

                ...extraValidations
            }
        }
    }
};

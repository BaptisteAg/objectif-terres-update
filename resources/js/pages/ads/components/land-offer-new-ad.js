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
        const v = this.oldValues;
        const hasOld = Object.keys(v).length;

        const extraFormInput = this.isSupportRequest ? {
            isBeneficiary: hasOld ? v.is_beneficiary : '1',
            isActivityTransfer: hasOld ? !!v.is_activity_transfer : '',

            buildingSurface: hasOld && v.land_offer.building ? v.land_offer.building.surface: '',
            buildingOfferGenres: hasOld && v.land_offer.building ? v.land_offer.building.offer_genres: [],

            houseSurface: hasOld && v.land_offer.house ? v.land_offer.house.surface: '',
            houseOfferGenres: hasOld && v.land_offer.house ? v.land_offer.house.offer_genres: [],
        } : {};

        return  {
            formInput: {
                selectedZones: hasOld ? v.selected_zones : [],

                surface: hasOld ? v.land_offer.surface : '',
                sauDescription: hasOld ? v.land_offer.sau_description : '',
                productionGenres: hasOld ? v.land_offer.production_genres : [],
                productionGenresWanted: hasOld ? v.land_offer.production_genres_wanted : [],
                bioCertifications: hasOld ? v.land_offer.bio_certifications : [],
                waterAccess: hasOld ? v.land_offer.water_access: '',
                waterAccessDescription: hasOld ? v.land_offer.water_access_description: '',
                altitude: hasOld ? v.land_offer.altitude: '',

                hasBuildings: hasOld ? v.land_offer.has_buildings : null,
                buildingDescription : hasOld && v.land_offer.building ? v.land_offer.building.description: '',

                hasHouses: hasOld ? v.land_offer.has_houses: null,
                houseDescription : hasOld && v.land_offer.house ? v.land_offer.houses_description : '',

                offerGenres: hasOld ? v.land_offer.offer_genres : [],
                price: hasOld ? v.land_offer.altitude : '',
                rentPrice: hasOld ? v.land_offer.altitude : '',
                testDescription : hasOld ? v.land_offer.test_description : '',
                chartConfirmation: false,


                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
                documents: hasOld ? JSON.parse(v.documents) : [],

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
            return this.formInput.waterAccess === "1";
        },
        isSaleOffer() {
            return this.formInput.offerGenres.includes("1");
        },
        isRentOffer() {
            return this.formInput.offerGenres.includes("2");
        },
        isTestOffer() {
            return this.formInput.offerGenres.includes("3");
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
                    minLength: minLength(5),
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
                        return this.isSaleOffer ? !!v : true
                    }
                },
                rentPrice: {
                    decimal,
                    required(v) {
                        return this.isRentOffer ? !!v : true
                    }
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

                ...extraValidations
            }
        }
    }
};

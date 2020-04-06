import FormNewAdMixin from "./mixins/form-new-ad-mixin";
import {maxLength, maxValue, minLength, required} from 'vuelidate/lib/validators'
import TextAreaCounter from "../../../components/TextAreaCounter";
import Autocomplete from '../../../components/Autocomplete'
import MultiSelect from "../../../components/MultiSelect";
import DocumentsUpload from "../../../components/DocumentsUpload"
import CustomCheckbox from "../../../components/CustomCheckbox"

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

        return {
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
                hasHouses: hasOld ? v.land_offer.has_houses: null,
                buildingsDescription : hasOld ? v.land_offer.buildings_description : '',
                housesDescription : hasOld ? v.land_offer.houses_description : '',
                offerGenres: hasOld ? v.land_offer.offer_genres : [],
                price: hasOld ? v.land_offer.altitude : '',
                rentPrice: hasOld ? v.land_offer.altitude : '',
                testDescription : hasOld ? v.land_offer.test_description : '',

                aboutProject: hasOld ? v.about_project_content : '',
                aboutContent: hasOld ? v.about_content : '',
                title: hasOld ? v.title : '',
                documents: hasOld ? JSON.parse(v.documents) : [],
                chartConfirmation: false,
                //isBeneficiary: hasOld ? v.is_beneficiary : '',
                //isActivityTransfer: hasOld ? !!v.is_activity_transfer : '',
                //confirmPriceFermage: hasOld ? !!v.confirm_price_fermage : false,
            }
        }
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
    validations: {
        formInput: {
            //isBeneficiary: {required},
            //isActivityTransfer: {required},
            bioCertifications: {
                required(values) { return values.length; }
            },
            surface: {
                required,
                maxValue: maxValue(1000)
            },
            sauDescription: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
            },
            productionGenres: {
                required(values) { return values.length; }
            },
            productionGenresWanted: {},
            waterAccess: {required},
            waterAccessDescription: {
                minLength: minLength(5),
                maxLength: maxLength(200),
            },
            altitude: {required},
            offerGenres: {required},
            price: {
                required(v) {
                    return this.isSaleOffer ? !!v : true
                }
            },
            rentPrice: {
                required(v) {
                    return this.isRentOffer ? !!v : true
                }
            },
            testDescription: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
            },
            buildingsDescription: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
            },
            housesDescription: {
                minLength: minLength(5),
                maxLength: maxLength(1000),
            },
            chartConfirmation: {
                checked(v) {return !!v}
            }
        }
    }
};

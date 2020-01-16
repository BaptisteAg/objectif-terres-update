import LandSeekNewAd from './components/land-seek-new-ad'
import LandOfferNewAd from './components/land-offer-new-ad'
import JobOfferNewAd from './components/job-offer-new-ad'

import Vue from 'vue'

Vue.component('new-ad', {
    components: {
        'new-land-seek-ad' : LandSeekNewAd,
        'new-land-offer-ad' : LandOfferNewAd,
        'new-job-offer-ad' : JobOfferNewAd
    },
    props: {
        oldAdTypeSelected: String
    },
    data() {
        return {
            adTypeSelected: this.oldAdTypeSelected,
        }
    },
    computed: {
        enabledFormIsInvalid() {
            return this.enabledForm && this.enabledForm.$v.$invalid
        },
        enabledForm() {
            return this.$children.find(children => !children.isInputDisabled);
        }
    },
    mounted() {
        window.addEventListener("beforeunload",  (e) => {
            if(this.isSubmitting) {
                return true;
            }
            const confirmationMessage = `
                    Êtes vous sûr de vouloir quitter cette page ?
                    Les données saisies seront perdues si elles n'ont pas été enregistrées.
                `;

            (e || window).returnValue = confirmationMessage; //Gecko + IE
            return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
        });
    },
    methods: {
        submit(e) {
            this.enabledForm.$v.$touch();
            if (this.enabledFormIsInvalid) {
                e.preventDefault();
                for (let key in Object.keys(this.enabledForm.$v.formInput)) {
                    const input = Object.keys(this.enabledForm.$v.formInput)[key];
                    if (input.includes("$")) return false;
                    if (this.enabledForm.$v.formInput[input].$error) {
                        this.enabledForm.$refs[input].focus();
                        break;
                    }
                }
                this.isSubmitting = false;
            }
            else {
                if(!confirm('Êtes-vous sûr de la saisie de votre annonce?')) {
                    this.isSubmitting = false;
                    e.preventDefault();
                } else {
                    this.isSubmitting = true;
                }
            }
        },
    }
});
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
            if (this.enabledForm.$v.$invalid){
                for (let key in Object.keys(this.enabledForm.$v.formInput)) {
                    // 2. Extract the input
                    const input = Object.keys(this.enabledForm.$v.formInput)[key];
                    // 3. Remove special properties
                    if (input.includes("$")) return false;
                    // 4. Check for errors
                    if (this.enabledForm.$v.formInput[input].$error) {
                        // 5. Focus the input with the error
                        this.enabledForm.$refs[input].focus();
                        // 6. Break out of the loop
                        break;
                    }
                }

            } else if(!confirm('Êtes-vous sûr de la saisie de votre annonce?')) {
                this.isSubmitting = false;
                e.preventDefault();

            }
            this.isSubmitting = true;
        },
    }
});
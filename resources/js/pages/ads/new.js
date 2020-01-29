import LandSeekNewAd from './components/land-seek-new-ad'
import LandOfferNewAd from './components/land-offer-new-ad'
import JobOfferNewAd from './components/job-offer-new-ad'
import AdTypeSelect from'../../components/AdTypeSelect'

import Vue from 'vue'

Vue.component('new-ad', {
    components: {
        'new-land-seek-ad': LandSeekNewAd,
        'new-land-offer-ad': LandOfferNewAd,
        'new-job-offer-ad': JobOfferNewAd,
        AdTypeSelect
    },
    props: {
        oldAdTypeSelected: String
    },
    data() {
        return {
            adTypeSelected: this.oldAdTypeSelected,
            enabledForm: null
        }
    },
    mounted() {
        // Avoid accidental page leaving
        window.addEventListener("beforeunload", (e) => {
            if (this.isSubmitting) {
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
            e.preventDefault();

            this.enabledForm.$v.$touch();

            if (this.enabledFormHasErrors()) {

                this.enabledForm.focusOnFirstError();
                this.enabledForm.setInputsBorderColor();

                this.isSubmitting = false;
            }
            else {
                if (!confirm('Êtes-vous sûr de la saisie de votre annonce?')) {
                    this.isSubmitting = false;
                } else {
                    this.isSubmitting = true;
                    this.$el.submit()
                }
            }
        },
        enabledFormHasErrors() {
            return this.enabledForm && this.enabledForm.$v.$error
        },
        setEnabledForm(form) {
            this.enabledForm = form;
        },
        onFormComplete() {
            const evt = new CustomEvent("submit", {"bubbles":true, "cancelable": true});
            this.$refs.form.dispatchEvent(evt);
        }
    }
});

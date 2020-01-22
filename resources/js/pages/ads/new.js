import LandSeekNewAd from './components/land-seek-new-ad'
import LandOfferNewAd from './components/land-offer-new-ad'
import JobOfferNewAd from './components/job-offer-new-ad'

import Vue from 'vue'

Vue.component('new-ad', {
    components: {
        'new-land-seek-ad': LandSeekNewAd,
        'new-land-offer-ad': LandOfferNewAd,
        'new-job-offer-ad': JobOfferNewAd
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
            this.enabledForm.$v.$touch();
            if (this.enabledFormHasErrors()) {
                e.preventDefault();
                this.focusOnFirstError(this.enabledForm);
                this.isSubmitting = false;
            } else {
                if (!confirm('Êtes-vous sûr de la saisie de votre annonce?')) {
                    this.isSubmitting = false;
                    e.preventDefault();
                } else {
                    this.isSubmitting = true;
                }
            }
        },
        enabledFormHasErrors() {
            return this.enabledForm && this.enabledForm.$v.$error
        },
        setEnabledForm(form) {
            this.enabledForm = form;
        },
        focusOnFirstError(vueForm) {
            for (let key in Object.keys(vueForm.$v.formInput)) {
                const inputName = Object.keys(vueForm.$v.formInput)[key];
                if (inputName.includes("$")) return false;
                if (vueForm.$v.formInput[inputName].$error) {
                    let input = vueForm.$refs[inputName];

                    if (input instanceof Vue) {
                        input = vueForm.$refs[inputName].$el
                    }
                    if (input instanceof Element) {
                        const tagNames = ['input', 'textarea', 'select'];

                        if (!tagNames.includes(input.tagName.toLowerCase())) {
                            input = input.querySelector(tagNames.join(','));
                        }
                    }
                    try {
                        input.focus();
                    } catch (error) {
                        console.log(error)
                    }
                    return true;
                }
            }
        }
    }
});
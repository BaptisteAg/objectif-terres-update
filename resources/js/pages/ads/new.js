import LandSeekNewAd from './components/land-seek-new-ad'
import LandOfferNewAd from './components/land-offer-new-ad'
import JobOfferNewAd from './components/job-offer-new-ad'
import JobSeekNewAd from './components/job-seek-new-ad'
import AdTypeSelect from '../../components/AdTypeSelect'

import Vue from 'vue'

Vue.component('new-ad', {
    components: {
        'new-land-seek-ad': LandSeekNewAd,
        'new-land-offer-ad': LandOfferNewAd,
        'new-job-offer-ad': JobOfferNewAd,
        'new-job-seek-ad': JobSeekNewAd,
        AdTypeSelect
    },
    props: {
        oldAdTypeSelected: String,
        isSupportRequest: Boolean
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

        // Force bulma-tooltip display on field hover
        document.querySelectorAll('.field').forEach($field => {
            const $hoveredTooltip = $field.querySelector('[data-tooltip]');

            $field.addEventListener('mouseover', event => {
                if ($hoveredTooltip) {
                    $hoveredTooltip.classList.add('has-tooltip-active');
                }
                document.querySelectorAll('[data-tooltip]').forEach($otherTooltip => {
                    if (!$otherTooltip.isEqualNode($hoveredTooltip)) {
                        $otherTooltip.classList.remove('has-tooltip-active')
                    }
                })
            })
        });


        /**
         * Move wizard footer to a container it can stick to ( position:sticky )
         *
         * @param {Element} $affix
         */
        document.querySelectorAll('.affix-wizard-footer[data-move-to-ref]').forEach($affix => {
            const $container = this.$refs[$affix.dataset.moveToRef].$el;
            const $removedAffix = $affix.parentElement.removeChild($affix);
            $container.appendChild($removedAffix);
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
            } else {
                const text = this.isSupportRequest ?
                    'Vous êtes sur le point de soumettre une demande d\'accompagnement. Elle sera traitée sous 7 jours par un primo-accueillant.' :
                    'Vous êtes sur le point de demander la pubication de votre annonce. Elle sera traitée sous 7 jours par un modérateur.';

                if (!confirm(text)) {
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
            const evt = new CustomEvent("submit", {"bubbles": true, "cancelable": true});
            this.$refs.form.dispatchEvent(evt);
        }
    }
});

import LandSeekNewAd from './components/land-seek-new-ad'
import LandOfferNewAd from './components/land-offer-new-ad'
import JobOfferNewAd from './components/job-offer-new-ad'
import JobSeekNewAd from './components/job-seek-new-ad'
import AssociateSeekNewNad from './components/associate-seek-new-ad'
import AssociateOfferNewNad from './components/associate-offer-new-ad'
import AdTypeSelect from '../../components/AdTypeSelect'
import OldAdTypeSelect from '../../components/AdTypeSelect.v1.vue'

import Vue from 'vue'


Vue.component('new-ad', {
    components: {
        'new-land-seek-ad': LandSeekNewAd,
        'new-land-offer-ad': LandOfferNewAd,
        'new-job-offer-ad': JobOfferNewAd,
        'new-job-seek-ad': JobSeekNewAd,
        'new-associate-seek-ad': AssociateSeekNewNad,
        'new-associate-offer-ad': AssociateOfferNewNad,
        AdTypeSelect,
        OldAdTypeSelect
    },
    props: {
        oldAdTypeSelected: String,
        isSupportRequest: Boolean,
    },
    data() {
        return {
            adTypeSelected: this.oldAdTypeSelected,
            createFromSupportRequest: null,
            createFromAd: null,
            enabledForm: null,
            formAction: this.getPublishAction()
        }
    },
    mounted() {
        // Avoid accidental page leaving
        window.addEventListener("beforeunload", (e) => {
            if (this.isSubmitting) {
                return true;
            }
            const confirmationMessage = `
                    Êtes vous sûr·e de vouloir quitter cette page ?
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

    },
    watch: {
        createFromSupportRequest(id) {
            id && (location.href = "/annonces/creer/copier-accompagnement/" + id);
        },
        createFromAd(id) {
            id && (location.href = "/accompagnement/creer/copier-annonce/" + id);
        },
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
                const text =
                    'Vous êtes sur le point de demander la publication de votre annonce. Elle sera traitée sous 7 jours par un modérateur.';

                if (this.formAction === this.publishAction && !confirm(text)) {
                    this.isSubmitting = false;
                } else {
                    this.isSubmitting = true;
                    this.$el.submit()
                }
            }
        },
        enabledFormHasErrors() {
            let hasErrors = this.enabledForm && this.enabledForm.$v?.$error
            return hasErrors;
        },
        setEnabledForm(form) {
            this.enabledForm = form;
        },

        submitProxy() {
            const evt = new CustomEvent("submit", {"bubbles": true, "cancelable": true});
            this.$refs.form.dispatchEvent(evt);
        },

        onSaveClick() {
            this.formAction = this.getSaveAction();
        },

        onPublishClick() {
            this.formAction = this.getPublishAction();
        },

        getPublishAction() {
            return '/annonces/creer';
        },

        getSaveAction() {
            return '/annonces/sauvegarder';
        }
    }
});

import Vue from 'vue';
import VueShepherd from 'vue-shepherd';


Vue.component('site-tour-shepherd', {
    components: {
        VueShepherd
    },
    props: {
        imagePath: ''
    },
    data() {
        return {}
    },
    mounted() {
        this.$nextTick(() => {
            const tour = this.$shepherd({
                useModalOverlay: true,
                defaultStepOptions: {
                    cancelIcon: {
                        enabled: true
                    },
                    classes: 'shepherd-theme-custom',
                    scrollTo: {
                        behavior: 'smooth',
                        block: 'center'
                    }
                }
            });

            tour.addStep({
                attachTo: {element: '#main-menu-items', on: 'bottom'},
                text: 'Trouvez dans ces menus des conseils pour réussir votre projet agricole.',
                buttons: [
                    {
                        text: 'Annuler',
                        action: tour.cancel,
                        secondary: true,
                    },
                    {
                        text: 'Suivant',
                        action: tour.next
                    }
                ]
            });
            tour.addStep({
                attachTo: {element: '#header-main-filters', on: 'bottom'},
                text: 'Effectuer une recherche rapide par région.',
                buttons: [
                    {
                        text: 'Précédent',
                        action: tour.back,
                        secondary: true,
                    },
                    {
                        text: 'Suivant',
                        action: tour.next
                    }
                ]
            });
            tour.addStep({
                attachTo: {element: '#global-map', on: 'top'},
                text: 'Visualiser les annonces sur une carte en choisissant une catégorie.',
                buttons: [
                    {
                        text: 'Précédent',
                        action: tour.back,
                        secondary: true,
                    },
                    {
                        text: 'Suivant',
                        action: tour.next
                    }
                ]
            });
            tour.addStep({
                attachTo: {element: '#header-main-cta', on: 'bottom'},
                text: ' Pour déposer un annonce ou demander à être accompagné, utilisez ces boutons',
                buttons: [
                    {
                        text: 'Précédent',
                        action: tour.back,
                        secondary: true,
                    },
                    {
                        text: 'Suivant',
                        action: tour.next
                    }
                ]
            });
            tour.addStep({
                attachTo: {element: '#top-bar-user-menu', on: 'bottom'},
                text: ' Créez rapidement un compte pour profiter de fonctionnalités avancées : messagerie, sauvegarde d’annonces et de recherches, alertes email...' +
                    '<br>' +
                    '<div class="has-text-centered">' +
                    '<img src="' + this.imagePath + '">' +
                    '</div> ',
                buttons: [
                    {
                        text: 'Précédent',
                        action: tour.back,
                        secondary: true,
                    },
                    {
                        text: 'Terminer',
                        action: tour.next
                    }
                ]
            });
            tour.start();
        });
    }
})
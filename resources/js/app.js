
//////////////
// VUE
window.Vue = require('vue');

 import Vuelidate from 'vuelidate';
 Vue.use(Vuelidate);

 import VueFormWizard from 'vue-form-wizard'
 import 'vue-form-wizard/dist/vue-form-wizard.min.css'
 Vue.use(VueFormWizard);

import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

import Vue from 'vue'
import Buefy from 'buefy'

Vue.use(Buefy)

require('vue-pagination-2/dist/vue-pagination-2.min');

Vue.prototype.$forceCompute= function(computedName, forceUpdate /* default: true */) {
    if (this._computedWatchers[computedName]) {
        this._computedWatchers[computedName].run();
        if (forceUpdate || typeof forceUpdate == 'undefined') this.$forceUpdate()
    }
}

//Composants vue
import Header from './components/header/index.vue';
Vue.component('vue-header', Header);
const GlobalMap = () => import('./components/home/map.vue');
Vue.component('global-map', GlobalMap);
const Newsletter = () => import('./components/Newsletter.vue');
Vue.component('newsletter', Newsletter);
const OurPartners = () => import('./components/OurPartners.vue');
Vue.component('our-partners', OurPartners);

//////////////
// VENDORS
window.SmoothScroll = require('smooth-scroll');

const app = new Vue({
    el: '#app',
});

//////////////
// LOCAL LIBS
require('./libs/fetchJson');

//////////////
// PAGES
require('./pages/support-request-start');
require('./pages/ads/new');
require('./pages/ads/show');
require('./pages/header');
require('./pages/auth/login-form');
require('./pages/auth/user-form');
require('./pages/threads/threads');
require('./pages/dashboard');
require('./pages/advisors/advisors');
require('./pages/supervisor/supervisor');
require('./pages/video');
require('./pages/cms/cms-page');
require('./pages/homepage/homepage');
require('./pages/researches/researches');
require('./pages/responseTemplates/responseTemplates');
require('./pages/site-tour/site-tour');

//////////////
// GLOBAL
require('./notifications');
require('./carrousel');
require('./main.js');

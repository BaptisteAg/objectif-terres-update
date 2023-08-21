
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
import GlobalMap from './components/home/map.vue';
Vue.component('global-map', GlobalMap);



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
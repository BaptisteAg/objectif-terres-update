
//////////////
// LODASH
_ = require('lodash');
//////////////
// VUE
window.Vue = require('vue');


import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard);

// Choose a deep merge strategy for the vuelidate properties
Vue.config.optionMergeStrategies.validations = function (toVal, fromVal) {
    return _.merge({}, fromVal, toVal);

};

require('vue-pagination-2/dist/vue-pagination-2.min');

//////////////
// VENDORS
window.SmoothScroll = require('smooth-scroll');

//////////////
// PAGES
require ('./pages/ads/new');
require ('./pages/ads/show');
require('./pages/header');
require('./pages/auth/login-form');
require('./pages/auth/user-form');
require('./pages/threads/threads');
require('./pages/dashboard');
require('./pages/advisors/advisors');
require('./pages/supervisor/supervisor');
require('./pages/video');
require('./pages/cms/contact-us-form');
//////////////
// GLOBAL
require('./main.js');

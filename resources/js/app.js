
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
require('awesomplete/awesomplete.min');

//////////////
// PAGES
require ('./pages/ads/new');
// require('./pages/researches/researches');
require('./pages/header');
require('./pages/auth/register');
require('./pages/threads/threads');

//////////////
// GLOBAL
require('./main.js');

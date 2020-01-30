/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

_ = require('lodash');

window.Vue = require('vue');

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard);

require('awesomplete/awesomplete.min');
require('vue-pagination-2/dist/vue-pagination-2.min');

require ('./pages/ads/new');


// require('./pages/researches/researches');

require('./pages/header');


require('./main.js');

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');

import Vuelidate from 'vuelidate';

Vue.use(Vuelidate);


require('awesomplete/awesomplete.min');
require('vue-pagination-2/dist/vue-pagination-2.min');

require ('./pages/ads/new');
// require('./pages/researches/researches');

require('./pages/header');



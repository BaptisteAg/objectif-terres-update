
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


require('vue-pagination-2/dist/vue-pagination-2.min');

//////////////
// VENDORS
window.SmoothScroll = require('smooth-scroll');
window.Waves = require('node-waves');

//////////////
// PAGES
require('./pages/support-request-start');
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
require('./pages/homepage/homepage');
//////////////
// GLOBAL
require('./main.js');
require('./notifications')

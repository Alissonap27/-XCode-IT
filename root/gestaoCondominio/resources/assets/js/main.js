import jQuery from 'jquery';
import Vue from 'vue';

window.$ = jQuery;
window.jQuery = jQuery;
window.Vue = Vue;
window.moment = require('moment');
window.laroute = require('./laroute.js');

require('jquery-mask-plugin');
require('bootstrap-sass');
require("bootstrap-notify");
$.notifyDefaults({ offset: 60, placement: { from: "top", align: "center" } });

/****************Vue js plugins*****************/
import VuejsDialog from "vuejs-dialog";
Vue.use(VuejsDialog, {
    html: true, loader: true, okText: 'Sim', cancelText: 'Não', animation: 'bounce',
});

// import VeeValidate from 'vee-validate';
// Vue.use(VeeValidate);

// import Multiselect from 'vue-multiselect';
// Vue.component('multiselect', Multiselect);
/**********************************************/

/***********Vue js custom components************/

import hello from "./components/hello.vue";
Vue.component('hello', hello);

import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask);

import formAddress from "./components/address/form-address.vue";
Vue.component('form-address', formAddress);

import errorMessage from "./components/message/error-message.vue";
Vue.component('error-message', errorMessage);

import formButtons from "./components/form-buttons.vue";
Vue.component('form-buttons', formButtons);

/***********************************************/

//Global js
require('./global.js');

//Require custom plugins
require('./plugins/laravel-ajax-token.js');
require('./plugins/btn-loading.js');
require('./plugins/loading.js');
require('./plugins/prevent-modal-enter.js');
require('./plugins/form-prevent-change.js');
require('./plugins/object-assign-polyfill.js');
require('./plugins/password-capslock.js');
require('./plugins/focus-first-field.js');
require('./plugins/bootstrap-tooltip.js');
require('./plugins/bootstrap-popover.js');
require('./plugins/jquery-masks.js');

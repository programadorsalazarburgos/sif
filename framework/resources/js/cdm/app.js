/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

window.Vue = require('vue');

Vue.component('menuprincipal', require('../components/cdm/menuprincipal.vue').default);
Vue.component('general', require('../components/cdm/general.vue').default);
Vue.component('indicadores', require('../components/cdm/indicadores.vue').default);

const app = new Vue({
    el: '#app',
});
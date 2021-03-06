/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('../bootstrap');

 window.Vue = require('vue');
 
 Vue.component('ficha_crea_admin', require('../components/infraestructura/ficha_crea_admin.vue').default);
 
 const app = new Vue({
     el: '#app',
 });
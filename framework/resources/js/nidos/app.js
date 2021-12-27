/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

window.Vue = require('vue');

Vue.component('administracion_duplas', require('../components/nidos/duplas/administracion_duplas.vue').default);
Vue.component('formulario_inscripcion', require('../components/nidos/talento_humano/formulario_inscripcion.vue').default);
Vue.component('gestion_formularios', require('../components/nidos/talento_humano/gestion_formularios.vue').default);

const app = new Vue({
    el: '#app',
});
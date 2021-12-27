/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
import Vue from 'vue';
window.Vue = require('vue');

Vue.component('administracion_metas_estadisticas', require('../components/administracion/administracion_metas_estadisticas.vue').default);
Vue.component('administracion_contenidos', require('../components/nidos/contenidos/administracion_contenidos.vue').default);
Vue.component('entrega_contenidos', require('../components/nidos/contenidos/entrega_contenidos.vue').default);
Vue.component('proyectos', require('../components/cdm/proyectos.vue').default);
Vue.component('registro_fortalecimiento_externo', require('../components/nidos/fortalecimiento/registro_fortalecimiento_externo.vue').default);
Vue.component('registro_asistencia_fortalecimiento_externo', require('../components/nidos/fortalecimiento/registro_asistencia_fortalecimiento_externo.vue').default);
Vue.component('administracion_oferta_fortalecimiento_externo', require('../components/nidos/fortalecimiento/administracion_oferta_fortalecimiento_externo.vue').default);
Vue.component('beneficiarios', require('../components/administracion/beneficiarios.vue').default);
Vue.component('oferta_disponible', require('../components/crea/oferta/oferta_disponible.vue').default);
Vue.component('administracion_oferta_disponible', require('../components/crea/oferta/administracion_oferta_disponible.vue').default);
Vue.component('arn', require('../components/nidos/circulacion/formularios/arn.vue').default);
Vue.component('aulas_hospitalarias', require('../components/nidos/circulacion/formularios/aulas_hospitalarias.vue').default);
Vue.component('reporte_revisiones', require('../components/crea/artistaFormador/reporte_revisiones.vue').default);
Vue.component('administracion_colegios_convenio', require('../components/nidos/transicion/administracion_colegios_convenio.vue').default);
Vue.component('formato_pedagogico', require('../components/crea/componentePedagogico/formato_pedagogico.vue').default);
Vue.component('reportemonitoreo', require('../components/reportes/general.vue').default);
Vue.component('administracion_grupos', require('../components/nidos/transicion/administracion_grupos.vue').default);
Vue.component('registro_experiencias', require('../components/nidos/transicion/registro_experiencias.vue').default);
Vue.component('formato_planeacion', require('../components/crea/componentePedagogico/formatoPedagogicoPlaneacion.vue').default);
Vue.component('analisis_seguimiento', require('../components/crea/componentePedagogico/formatoAnalisisFormativo.vue').default);
Vue.component('reportedigital', require('../components/reportes/digitalMensual/general.vue').default);
Vue.component('seguimientopsicosocial', require('../components/seguimientoPsicosocial/general.vue').default);

const app = new Vue({
    el: '#app',
});
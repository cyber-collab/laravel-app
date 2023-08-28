require('./bootstrap');
window.Vue = require('vue');
import 'vuejs-datatable/dist/themes/bootstrap-4.esm';
import Vue from "vue";
import { VuejsDatatableFactory } from 'vuejs-datatable';
Vue.use( VuejsDatatableFactory );

Vue.component('datatable-component', require('./components/DatatableComponent.vue').default);
const app = new Vue({
    el: '#app',
});

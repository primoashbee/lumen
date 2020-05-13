/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import { VueMaskDirective } from 'v-mask';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
window.numeral = require('numeral');


window.Vue = require('vue');
// window.flatten = require('flat')
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Swal = require('sweetalert2');
window.moment = require('moment');
// import VuePaginate from 'vue-paginate'
// Vue.use(VuePaginate)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

Vue.directive('mask', VueMaskDirective);

Vue.component('org-structure', require('./components/OfficeStructureComponent.vue').default);
Vue.component('structure-filter', require('./components/StructureFilterComponent.vue').default);
Vue.component('date-picker', require('./components/DatePickerComponent.vue').default);
Vue.component('v2-select', require('./components/SelectComponentV2.vue').default);
Vue.component('create-client-form', require('./components/ClientCreateFormComponent.vue').default);
Vue.component('update-client-form', require('./components/ClientUpdateFormComponent.vue').default);
Vue.component('client-list', require('./components/ClientListComponent.vue').default);
Vue.component('paginator', require('./components/PaginatorComponent.vue').default);
Vue.component('upload-file', require('./components/UploadSampleComponent.vue').default);
Vue.component('create-office', require('./components/CreateOfficeComponent.vue').default);
Vue.component('light-modal', require('./components/ModalComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('office-list', require('./components/OfficeListComponent.vue').default);
Vue.component('deposit-dashboard', require('./components/DepositDashboardComponent.vue').default);
Vue.component('payment-methods', require('./components/PaymentMethodComponent.vue').default);
Vue.component('multi-search', require('./components/MultiSearchComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});


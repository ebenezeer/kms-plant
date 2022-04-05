/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';
import routes from './routes';


import 'sweetalert2/src/sweetalert2.scss';

import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
Vue.component("v-select", vSelect);

Vue.component('admin-sidebar', require('./components/administrator/sidebar').default);
Vue.component('expert-sidebar', require('./components/expert/sidebar').default);
Vue.component('pub-sidebar', require('./components/publicuser/sidebar').default);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);


Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});

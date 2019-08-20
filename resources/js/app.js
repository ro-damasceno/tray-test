/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;
window.VueMoment = Vue.use(require('vue-moment'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const SellerComponent 	     = require('./components/sellers/sellers.component.vue').default;
const SellerProfileComponent = require('./components/sellers/seller-profile.component.vue').default;

Vue.component('seller-edit-modal', require('./components/sellers/seller-edit.component.vue').default);
Vue.component('order-edit-modal', require('./components/orders/order-edit.component.vue').default);

Vue.component('order-list', require('./components/orders/orders.component.vue').default);
Vue.component('paginator-component', require('./components/paginator/paginator.component.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const routes = [
	{ path: '/', component: SellerComponent },
	{ path: '/sellers/:id', component: SellerProfileComponent, name: 'seller-profile' }
];

const router = new VueRouter({
	routes
});

const app = new Vue({ router }).$mount('#app');

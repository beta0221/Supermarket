/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

//全元件溝
window.EventBus = new Vue();

import CoreuiVue from '@coreui/vue';
Vue.use(CoreuiVue);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))




//------註冊元件------

Vue.component('Home',require('./components/Home.vue').default);
Vue.component('SideBar',require('./components/SideBar').default)











//------註冊路徑------

import VueRouter from 'vue-router'
Vue.use(VueRouter)

const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }
import CategoryPage from './components/Pages/CategoryPage'
const routes = [
    { path: '/admin/foo', component: Foo },
    { path: '/admin/bar', component: Bar },
    { path: '/admin/category',component: CategoryPage},
]

const router = new VueRouter({
    routes,
    mode:'history',
})




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});

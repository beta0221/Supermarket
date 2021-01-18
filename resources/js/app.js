/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

//全元件溝通
window.EventBus = new Vue();
//訊息顯示器
import messageHelper from './helpers/messageHelper'
window.messageHelper = new messageHelper();
//錯誤處理器
import errorHelper from './helpers/errorHelper'
window.errorHelper = new errorHelper();
//後台介面套件
import CoreuiVue from '@coreui/vue';
Vue.use(CoreuiVue);
//文字編輯器
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use(CKEditor)

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
Vue.component('SideBar',require('./components/SideBar').default);
Vue.component('NavBar',require('./components/NavBar').default);
Vue.component('DataTable',require('./components/DataTable').default);
Vue.component('DataDetailModal',require('./components/DataDetailModal').default);
Vue.component('CreateDetailModal',require('./components/CreateDetailModal').default);
Vue.component('SingleSelector',require('./components/SingleSelector').default);
Vue.component('MultipleSelector',require('./components/MultipleSelector').default);
Vue.component('TextEditor',require('./components/TextEditor').default);
Vue.component('ImageInput',require('./components/ImageInput').default);
Vue.component('OrderDetailModal',require('./components/OrderDetailModal').default);







//------註冊路徑------

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import CategoryPage from './components/Pages/CategoryPage'
import AttributePage from './components/Pages/AttributePage'
import AttributeSetPage from './components/Pages/AttributeSetPage'
import ProductGroupPage from './components/Pages/ProductGroupPage'
import ProductPage from './components/Pages/ProductPage'
import SpecificPricePage from './components/Pages/SpecificPricePage'
import OrderPage from './components/Pages/OrderPage'
import CountryPage from './components/Pages/CountryPage'
import CarrierPage from './components/Pages/CarrierPage'
import PaymentPage from './components/Pages/PaymentPage'
import CartRulePage from './components/Pages/CartRulePage'
import MemberPage from './components/Pages/MemberPage'
import BannerPage from './components/Pages/BannerPage'
const routes = [
    { path: '/admin/category',component: CategoryPage},
    { path: '/admin/attribute', component: AttributePage },
    { path: '/admin/attributeSet',component: AttributeSetPage},
    { path: '/admin/productGroup',component: ProductGroupPage},
    { path: '/admin/product',component: ProductPage},
    { path: '/admin/specificPrice',component: SpecificPricePage},
    { path: '/admin/order',component: OrderPage},
    { path: '/admin/country',component: CountryPage},
    { path: '/admin/carrier',component: CarrierPage},
    { path: '/admin/payment',component: PaymentPage},
    { path: '/admin/cartRule',component: CartRulePage},
    { path: '/admin/member' ,component: MemberPage},
    { path: '/admin/banner' , component: BannerPage},
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

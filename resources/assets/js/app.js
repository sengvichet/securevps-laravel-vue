import { event } from './utils'
import { ServerTable, ClientTable, Event } from 'vue-tables-2'


/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

let clientTableOptions = {
    ordering:true,
    compileTemplates: true,
    perPage: 30,
    sortIcon: {
        base:'fa fa-sort',
        up:'fa fa-sort-asc',
        down:'fa fa-sort-desc'
    },
    skin: 'tblmarkpink',
    texts: {
        count: 'מציג {from} עד {to} מתוך {count} תוצאות',
        filter: 'סינון:',
        filterPlaceholder: 'חפש...',
        limit: 'תוצאות בדף:',
        noResults: 'לא נמצאו רשומות',
        page: 'דף:',
        filterBy: 'סנן לפי {column}',
        loading: 'טוען...',
    }
}

Vue.use(ClientTable, clientTableOptions)
Vue.use(ServerTable, clientTableOptions)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('loginbysms', require('./components/auth/login-by-sms-form.vue'));
Vue.component('validateloginsms', require('./components/auth/validate-login-sms-form.vue'));
Vue.component('adminloginbysms', require('./components/auth/admin-login-by-sms-form.vue'));
Vue.component('users', require('./components/admin/users.vue'));
Vue.component('domainspaces', require('./components/user/domain-spaces.vue'));
Vue.component('items', require('./components/admin/items.vue'));
Vue.component('cart', require('./components/catalog/cart.vue'));
Vue.component('wizard', require('./components/catalog/wizard.vue'));
Vue.component('payment', require('./components/catalog/payment.vue'));
Vue.component('sessions', require('./components/admin/sessions.vue'));
Vue.component('orders', require('./components/admin/orders.vue'));
Vue.component('local-users', require('./components/admin/local-users.vue'));
Vue.component('domain-spaces', require('./components/admin/domain-spaces.vue'));
Vue.component('invoices', require('./components/user/invoices.vue'));
Vue.component('receipts', require('./components/user/receipts.vue'));
Vue.component('cookie-policy', require('./components/user/cookie-policy.vue'));
Vue.component('get-invoice-years', require('./components/user/get-invoice-years.vue'));
Vue.component('credit-cards', require('./components/user/credit-cards.vue'));

const app = new Vue({
    el: '#app',
    created () {
        event.init()
        //http.init()
    }
});

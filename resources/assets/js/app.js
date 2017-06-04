
require('./bootstrap');

window.Vue = require('vue');

window.bus = new Vue();

Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('day-count', require('./components/DayCount.vue'));
Vue.component('last-update', require('./components/LastUpdate.vue'));

const app = new Vue({
    el: '#app'
});

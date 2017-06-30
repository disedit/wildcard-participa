require('./bootstrap');

window.Vue = require('vue');
window.Bus = new Vue();

import VueRouter from 'vue-router';
import Participa from './api';
import BootstrapVue from 'bootstrap-vue';
import Booth from './components/Booth';

window.Participa = new Participa();

Vue.use(VueRouter);
Vue.use(BootstrapVue);

const router = new VueRouter({
    mode: 'history',
    routes: [
        { name: 'ballot', path: '/', component: Booth, alias: '/booth/ballot' },
        { name: 'verify', path: '/booth/verify', component: Booth },
        { name: 'receipt', path: '/booth/receipt', component: Booth },
    ],
  });

const app = new Vue({
  el: '#booth',
  components: {
      Booth,
    },
  router,
  template: '<booth />',
});

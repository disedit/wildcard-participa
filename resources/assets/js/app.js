require('./bootstrap');

window.Vue = require('vue');
window.Bus = new Vue();

import Participa from './api';
import BootstrapVue from 'bootstrap-vue';

window.Participa = new Participa();

Vue.use(BootstrapVue);
Vue.component('booth', require('./components/Booth.vue'));

const app = new Vue({
  el: '#booth',
  template: '<booth />',
});

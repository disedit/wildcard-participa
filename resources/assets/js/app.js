require('./bootstrap');

window.Vue = require('vue');
window.Bus = new Vue();

import Participa from './api';
window.Participa = new Participa();

Vue.component('booth', require('./components/Booth.vue'));

const app = new Vue({
  el: '#booth',
  template: '<booth />',
});

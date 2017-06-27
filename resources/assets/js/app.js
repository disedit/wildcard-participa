require('./bootstrap');

window.Vue = require('vue');
window.Bus = new Vue();

Vue.component('booth', require('./components/Booth.vue'));

const app = new Vue({
  el: '#booth',
  template: '<booth />',
});

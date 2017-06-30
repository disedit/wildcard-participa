require('./bootstrap');

window.Vue = require('vue');
window.Bus = new Vue();

import VueRouter from 'vue-router';
import Participa from './api';
import BootstrapVue from 'bootstrap-vue';

import Booth from './components/Booth';
import BoothBallot from './components/BoothBallot';
import BoothVerify from './components/BoothVerify';
import BoothReceipt from './components/BoothReceipt';

window.Participa = new Participa();

Vue.use(VueRouter);
Vue.use(BootstrapVue);

const scrollBehavior = (to, from, savedPosition) => {
    return { x: 0, y: 0 };
  };

const router = new VueRouter({
    mode: 'history',
    scrollBehavior,
    routes: [
        {
            path: '/',
            component: Booth,
            children: [
                { path: '', component: BoothBallot },
                { path: 'booth/verify', component: BoothVerify },
                { path: 'booth/receipt', component: BoothReceipt },
            ]
        },
    ],
  });

const app = new Vue({
    el: '#booth',
    router,
    template: '<transition name="fade" mode="out-in"><router-view /></transition>'
});

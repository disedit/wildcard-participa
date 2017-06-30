require('./bootstrap');

window.Vue = require('vue');
window.Bus = new Vue();

import VueRouter from 'vue-router';
import VueI18n from 'vue-i18n'
import BootstrapVue from 'bootstrap-vue';

import Participa from './api';

import Booth from './components/Booth';
import BoothBallot from './components/BoothBallot';
import BoothVerify from './components/BoothVerify';
import BoothReceipt from './components/BoothReceipt';

import Catalan from './language/ca.js';
import Spanish from './language/es.js';
import English from './language/en.js';

window.Participa = new Participa();

Vue.use(VueRouter);
Vue.use(VueI18n);
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

const messages = {
  en: English,
  ca: Catalan,
  es: Spanish
}

const i18n = new VueI18n({
    locale: 'en',
    messages,
});

const app = new Vue({
    el: '#booth',
    router,
    i18n,
    template: '<transition name="fade" mode="out-in"><router-view /></transition>'
});

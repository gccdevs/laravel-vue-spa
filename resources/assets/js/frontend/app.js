/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// vendor
require('../bootstrap');
window.Vue = require('vue');

import 'babel-polyfill'
import Buefy from 'buefy';
import Cleave from 'cleave.js';
import Toasted from 'vue-toasted';

import router from './router';
import store from './store/index';
import api from 'src/Api';
import KitLoader from 'src/KitLoader';
import VueMarkdown from 'vue-markdown';
import storage from 'src/Storage';
import VueI18n from 'vue-i18n';
import 'buefy/dist/buefy.css';
import vueScrollto from 'vue-scrollto';
import tw from './lang/tw';
import en from './lang/en';
require('./sass/app.scss');

Vue.use(vueScrollto);
Vue.use(Buefy);
Vue.use(api);
Vue.use(storage);
Vue.use(VueI18n);
Vue.use(VueMarkdown);
Vue.component('vue-markdown', VueMarkdown);
KitLoader.loadUIComponents(Vue, 'frontend');
Vue.use(Toasted, {
    position: 'top-center',
    duration: 3000,
});
// Register a global custom directive called `v-cleave` for input validating
Vue.directive('cleave', {
    bind(el, binding) {
        const input = el.querySelector('input');
        input._vCleave = new Cleave(input, binding.value);
    },
    update(el, binding) {
        const input = el.querySelector('input');
        input._vCleave.destroy();
        input._vCleave = new Cleave(input, binding.value);
    },
    unbind(el) {
        const input = el.querySelector('input');
        input._vCleave.destroy();
    }
});

let lang = 'tw';
if (document.documentElement.lang === 'zh') {
    lang = 'zh';
} else if (document.documentElement.lang === 'en') {
    lang = 'en';
}
let messages = {
    en: en,
    tw: tw
}
const i18n = new VueI18n({
    locale: lang,
    messages,
});

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    mounted () {
        Vue.$storage.loadVueLocalStorage(store);
    }
});
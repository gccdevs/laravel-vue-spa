
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// vendor
require('../bootstrap');
window.Vue = require('vue');

// 3rd party
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import 'babel-polyfill'
import router from './router';
import store from './store/index';
import eventBus from 'src/Event';
import api from 'src/Api';
import formatters from 'src/Formatters';
import KitLoader from 'src/KitLoader';
import VueMarkdown from 'vue-markdown';
import storage from 'src/Storage';
import VueI18n from 'vue-i18n';
import Toasted from 'vue-toasted';

import zh from './lang/zh';
import tw from './lang/tw';
import en from './lang/en';
import VueClipboard from 'vue-clipboard2';
import vueScrollto from 'vue-scrollto';

Vue.use(vueScrollto);
Vue.use(VueClipboard);
Vue.component('moon-loader', require('vue-spinner/src/MoonLoader.vue'));

Vue.use(Vuetify, {
    theme: {
        primary: '#4b5fe2',
        lighter_primary: '#8D9AED',
        darker_primary: '#1F35C1',
        secondary: '#8eb4cb',
        success: '#2ab27b',
        warning: '#cbb956',
    }
});
Vue.use(api);
Vue.use(storage);
Vue.use(formatters);
Vue.use(eventBus);
Vue.use(VueMarkdown);
Vue.component('vue-markdown', VueMarkdown);
Vue.use(VueI18n);
Vue.use(Toasted, {
    position: 'top-center',
    duration: 5000,
});

let messages = {
    en: en,
    zh: zh,
    tw: tw
}

let lang = 'tw';

if (document.documentElement.lang === 'zh') {
    lang = 'zh';
} else if (document.documentElement.lang === 'en') {
    lang = 'en';
}

const i18n = new VueI18n({
    locale: lang,
    messages,
});

KitLoader.loadUIComponents(Vue, 'backend');

const admin = new Vue({
    el: '#admin',
    eventBus,
    router,
    store,
    i18n,
    data: () => ({
        drawer: true,
        showPasswordModal: false,
        passwordRef: 0,
        showLangSelector: false,
    }),
    computed: {
        showLoader() {
            return store.getters.showLoader;
        },
        showSnackbar: {
            get() {
                return store.getters.showSnackbar;
            },
            set(val) {
                if(!val) store.commit('hideSnackbar');
            }
        },
        snackbarMessage() {
            return store.getters.snackbarMessage;
        },
        snackbarColor() {
            return store.getters.snackbarColor;
        },
        snackbarDuration() {
            return store.getters.snackbarDuration;
        },

        // dialog
        showDialog: {
            get() {
                return store.getters.showDialog;
            },
            set(val) {
                if(!val) store.commit('hideDialog');
            }
        },
        dialogType() {
            return store.getters.dialogType
        },
        dialogTitle() {
            return store.getters.dialogTitle
        },
        dialogMessage() {
            return store.getters.dialogMessage
        }
    },
    methods: {
        switchLang(lang) {
            if (lang !== 'zh' && lang !== 'en' && lang !== 'tw') {
                return;
            }
            this.$api.postRoute('backend.switch.lang', {}, {lang: lang}).then(response => {
                console.log(response);
                i18n.locale = response.data.lang;
                document.documentElement.lang = response.data.lang;
                location.reload();
            });
        },
        changePassword() {
            this.showPasswordModal = true;
        },
        passwordModalClose () {
            this.passwordRef++;
            this.showPasswordModal = false;            
            this.$refs.passwordChange.$destroy();
        },
        menuClick(routeName, routeType) {

            let rn = routeType || 'vue';

            if(rn==='vue') {

                this.$router.push({name: routeName});
            }
            if(rn==='full_load') {

                window.location.href = routeName;
            }
        },
        clickLogout(logoutUrl,afterLogoutRedirectUrl) {
            axios.post(logoutUrl).then((r)=>{
                window.location.href = afterLogoutRedirectUrl;
            });
        },
        dialogOk() {
            store.commit('dialogOk');
        },
        dialogCancel() {
            store.commit('dialogCancel');
        },
    },
    mounted () {
        // We load cached items from persisted local storage
        Vue.$storage.loadVueLocalStorage(store);

        this.$store.dispatch('User/getCurrentUser').then(response => {
        })
    }
});

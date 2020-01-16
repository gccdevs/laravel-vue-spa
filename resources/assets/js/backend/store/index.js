import Vue from 'vue';
import Vuex from 'vuex';
import User from './modules/user';
import FormBuilder from './modules/form-builder';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        User,
        FormBuilder,
    },
    state: {

        // loader
        showLoader: false,

        // snackbar
        showSnackbar: false,

        snackbarMessage: '',
        snackbarColor: '',
        snackbarDuration: 3000
    },
    mutations: {

        // loader
        showLoader(state) {
            state.showLoader = true
        },
        hideLoader(state) {
            state.showLoader = false
        },

        // snackbar
        showSnackbar(state, data) {
            state.snackbarDuration = data.duration || 3000;
            state.snackbarMessage = data.message || 'No message.';
            state.snackbarColor = data.color || 'info';
            state.showSnackbar = true;
        },
        hideSnackbar(state) {
            state.showSnackbar = false;
        }
    },
    getters: {

        // loader
        showLoader: state => {
            return state.showLoader
        },
        // snackbar
        showSnackbar: state => {
            return state.showSnackbar
        },
        snackbarMessage: state => {
            return state.snackbarMessage
        },
        snackbarColor: state => {
            return state.snackbarColor
        },
        snackbarDuration: state => {
            return state.snackbarDuration
        }
    }
});

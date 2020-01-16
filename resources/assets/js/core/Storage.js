import VueLocalStorage from 'vue-ls';
import { extend, get } from 'lodash';

class Storage {
    constructor (options) {
        this.options = extend({}, Storage.DEFAULTS, options)
    }

    install (Vue) {
        // Add VueLocalStorage as dependency
        Vue.use(VueLocalStorage, {
            namespace: this.options.namespace
        });

        // Maintain direct access to the local storage
        this.ls = Vue.ls;

        Vue.$storage = this;
        Vue.prototype.$storage = this;

        if (this.shouldClose()) {
            console.log('Vue local storage closed');
            this.clear();
        }
    }

    /**
     * Set key value in local storage
     * @param {String} key
     * @param {Mixed}  val
     */
    set (key, val = null) {
        return this.ls.set(key, val);
    }

    /**
     * Get value in local storage by key
     * @param {String} key
     * @param {Mixed}  default value if not set
     */
    get (key, def) {
        return this.ls.get(key, def);
    }

    /**
     * Remove given key from storage
     * @param key
     * @returns {*}
     */
    remove (key) {
        return this.ls.remove(key);
    }

    /**
     * Load current storage content into given Vuex store
     *
     * @param  {Store}  store
     * @return {void}
     */
    loadVueLocalStorage (store) {
        const currentFormBuilder = this.ls.get('current_form_builder');
        if (currentFormBuilder) {
            store.dispatch('FormBuilder/batchUpdate', currentFormBuilder);
            console.warn('Local Storage - Form details loaded');
        }
    }

    /**
     * Clear storage
     * @return {void}
     */
    clear () {
        this.ls.set('current_form_builder', null);
        this.ls.set('clean_cache', window.ALLOW_VUE_CACHE);
    }

    /**
     * Check if the local storage should be busted as instructed by application
     * @return {Boolean}
     */
    shouldClose () {
        let allowCache = window.ALLOW_VUE_CACHE;
        if (!allowCache) {
            return true;
        }
        return (this.ls.get('clean_cache', null) !== allowCache);
    }
}

Storage.DEFAULTS = {
    namespace: 'FormBuilder'
};

export default new Storage()

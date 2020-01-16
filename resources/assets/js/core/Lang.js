import { extend } from 'lodash'

class Lang {
    constructor (options) {
        options = extend({}, Lang.DEFAULTS, options);
        this.options = options;
    }

    install (Vue, { dictionary = '' }) {
        /**
         * Make API client available as
         * Vue.$lang and this.$lang (within components)
         */
        Vue.$lang = this;
        Vue.prototype.$lang = this;
        this.dictionary = dictionary;
    }

    get (key) {
        return this.dictionary[key];
    }
}

Lang.DEFAULTS = {
}

export default new Lang();

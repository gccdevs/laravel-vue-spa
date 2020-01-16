import Vue from 'vue'
import VueMask from 'v-mask'

let KitLoader = {

    /**
     * Load all backend vue components
     * @param Vue
     */
    loadUIComponents (Vue, location) {
        // Load component dependencies
        this.loadDependencies();
        if (location === 'backend') {
            this.loadContext(require.context('./../backend/pages/', false, /\.vue$/), Vue)
            this.loadContext(require.context('./../backend/components/', false, /\.vue$/), Vue)
        } else if (location === 'frontend') {
            this.loadContext(require.context('./../frontend/pages/', false, /\.vue$/), Vue)
            this.loadContext(require.context('./../frontend/components/', false, /\.vue$/), Vue)
        }
    },

    /**
     * Load external dependencies required by UI Components
     *
     * @return {void}
     */
    loadDependencies () {
        Vue.use(VueMask);
    },

    /**
     * Load component files using context
     *
     * @param  {Context} context
     * @param  {Vue}     Vue       Vue instance
     * @return void
     */
    loadContext (context, Vue) {
        context.keys().forEach(key => {
            let componentName = key.split('/').reverse()[0];
            componentName = componentName.replace('.vue', '');
            if (componentName === 'index') {
                return;
            }
            Vue.component(componentName, context(key))
        });
    }

};

export default KitLoader

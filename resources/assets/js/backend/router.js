import Vue from 'vue';
import Router from 'vue-router';
import PageEventPlanner from './pages/PageEventPlanner';
import PageFormBuilder from './pages/PageFormBuilder';
import PageFormShow from './pages/PageFormShow';
import PageHome from './pages/PageHome';
import store from './store/index';

Vue.use(Router);

const router = new Router({
    mode: 'history',

    routes: [
        {
          path: '/admin',
          redirect: '/admin/dashboard'
        },
        {
            path: '/admin/dashboard',
            name: 'admin.home',
            component: PageHome
        },
        {
            name: 'admin.form.list',
            path: '/admin/forms',
            component: PageFormShow
        },
        {
            name: 'admin.form.builder',
            path: '/admin/form-builder',
            props: true,
            component: PageFormBuilder
        },
        {
            name: 'admin.form.edit',
            path: '/admin/form-builder/edit/:id',
            props: true,
            component: PageFormBuilder
        },
        {
            name: 'admin.event.index',
            path: '/admin/event-planner',
            props: true,
            component: PageEventPlanner
        }        
    ]
});

router.beforeEach((to, from, next) => {
    store.commit('showLoader');
    next();
});

router.afterEach((to, from) => {
    setTimeout(()=>{
        store.commit('hideLoader');
    },1000);
});

export default router;
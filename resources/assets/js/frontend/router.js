import Vue from 'vue';
import Router from 'vue-router';
import PageEvents from './pages/PageEvents';
import PageSingleEvent from './pages/PageSingleEvent';
import PageFundraising from './pages/PageFundraising';

Vue.use(Router);

const router = new Router({
    mode: 'history',

    routes: [
        {
            path: '/events',
            name: 'events.home',
            component: PageEvents,
            meta: {
                title: 'GCC Hub - 活动',
                metaTags: [
                    {
                        name: 'description',
                        content: 'The archive events page.'
                    },
                    {
                        property: 'og:description',
                        content: 'The archive events page.'
                    }
                ]
            }
        },
        {
            path: '/events/:event',
            name: 'event.single',
            component: PageSingleEvent,
            meta: {
                title: 'GCC Hub - 活动',
                metaTags: [
                    {
                        name: 'description',
                        content: 'The single event page.'
                    },
                    {
                        property: 'og:description',
                        content: 'The single event page.'
                    }
                ]
            }
        },
        {
            path: '/arise-and-shine',
            name: 'fundraising.index',
            component: PageFundraising,
            meta: {
                title: 'GCC Hub - 建堂奉献',
                metaTags: [
                    {
                        name: 'description',
                        content: '榮耀城教會渴望每一位家人能夠享受一起成長的喜樂'
                    },
                    {
                        property: 'og:description',
                        content: '榮耀城教會渴望每一位家人能夠享受一起成長的喜樂'
                    }
                ]
            }
        }
    ]
});

router.beforeEach((to, from, next) => {

    console.log(to.query);
    if (to.query.lang === 'en') {
        to.meta.title = 'GCC - Fundraising'
    }
    // This goes through the matched routes from last to first, finding the closest route with a title.
    // eg. if we have /some/deep/nested/route and /some, /deep, and /nested have titles, nested's will be chosen.
    const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);

    // Find the nearest route element with meta tags.
    const nearestWithMeta = to.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);
    const previousNearestWithMeta = from.matched.slice().reverse().find(r => r.meta && r.meta.metaTags);

    // If a route with a title was found, set the document (page) title to that value.
    if(nearestWithTitle) document.title = nearestWithTitle.meta.title;

    // Remove any stale meta tags from the document using the key attribute we set below.
    Array.from(document.querySelectorAll('[data-vue-router-controlled]')).map(el => el.parentNode.removeChild(el));

    // Skip rendering meta tags if there are none.
    if(!nearestWithMeta) return next();

    // Turn the meta tag definitions into actual elements in the head.
    nearestWithMeta.meta.metaTags.map(tagDef => {
        const tag = document.createElement('meta');

        Object.keys(tagDef).forEach(key => {
            tag.setAttribute(key, tagDef[key]);
        });

        // We use this to track which meta tags we create, so we don't interfere with other ones.
        tag.setAttribute('data-vue-router-controlled', '');

        return tag;
    })
    // Add the meta tags to the document head.
    .forEach(tag => document.head.appendChild(tag));
    //
    // document.title = to.meta.title;
    // document.metatags = to.meta.metaTags;

    window.scrollTo(0, 0);

    next();
});

router.afterEach((to, from) => {
});

export default router;

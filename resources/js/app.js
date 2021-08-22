require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
import PortalVue from 'portal-vue';
import LoadingPlugin from '@/Plugins/LoadingPlugin.js'

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.use(Vuesax)
Vue.use(LoadingPlugin)

const app = document.getElementById('app');

Vue.filter('formatNumber',  value => {
    return parseFloat(value)
});

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);

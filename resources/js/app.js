import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/index.esm.js';
import { createPinia } from 'pinia';
import { createI18n } from 'vue-i18n';

import messages from '@/i18n/messages';

const appName = import.meta.env.VITE_APP_NAME || 'Alexandar Palace';
const pageComponents = import.meta.glob('./Pages/**/*.vue');

const resolvePage = (name) => {
    if (name === 'Booking') {
        return import('./Pages/Booking.vue');
    }

    return resolvePageComponent(`./Pages/${name}.vue`, pageComponents);
};

const i18n = createI18n({
    legacy: false,
    locale: document.documentElement.lang || 'en',
    fallbackLocale: 'en',
    messages,
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: resolvePage,
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(createPinia())
            .use(i18n);

        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});


import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/index.esm.js';
import { createPinia } from 'pinia';
import { createI18n } from 'vue-i18n';

import defaultMessages from '@/i18n/messages';

const appName = import.meta.env.VITE_APP_NAME || 'Alexandar Palace';
const pageComponents = import.meta.glob('./Pages/**/*.vue');

const resolvePage = (name) => {
    if (name === 'Booking') {
        return import('./Pages/Booking.vue');
    }

    return resolvePageComponent(`./Pages/${name}.vue`, pageComponents);
};

// Deep merge function to combine default and database translations
const deepMerge = (target, source) => {
    const result = { ...target };
    for (const key in source) {
        if (source[key] && typeof source[key] === 'object' && !Array.isArray(source[key])) {
            result[key] = deepMerge(result[key] || {}, source[key]);
        } else if (source[key] !== undefined && source[key] !== '') {
            result[key] = source[key];
        }
    }
    return result;
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: resolvePage,
    setup({ el, App, props, plugin }) {
        // Get database translations from page props
        const dbTranslations = props.initialPage.props.dbTranslations || { en: {}, mk: {} };
        
        // Merge database translations with defaults (database takes priority)
        const messages = {
            en: deepMerge(defaultMessages.en, dbTranslations.en),
            mk: deepMerge(defaultMessages.mk, dbTranslations.mk),
        };

        const i18n = createI18n({
            legacy: false,
            locale: props.initialPage.props.locale || 'en',
            fallbackLocale: 'en',
            messages,
        });

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


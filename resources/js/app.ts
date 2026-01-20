import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { initializeTheme } from './composables/useAppearance';
// import Editor from '@tinymce/tinymce-vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const corePages = import.meta.glob<DefineComponent>('./pages/**/*.vue');
const modulePages = import.meta.glob<DefineComponent>('@modules/**/resources/js/Pages/**/*.vue');
const pages = { ...corePages, ...modulePages };

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const inertiaPath = `./pages/${name}.vue`;
        const modulePath = Object.keys(modulePages).find((path) => path.endsWith(`/Pages/${name}.vue`));
        const candidatePaths = modulePath ? [inertiaPath, modulePath] : [inertiaPath];

        return resolvePageComponent(candidatePaths, pages);
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

import '../css/app.css';
import './bootstrap';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

const showLoader = () => {
    const loader = document.getElementById('app-loader');

    if (loader) {
        loader.classList.remove('hidden');
    }
};

const hideLoader = () => {
    const loader = document.getElementById('app-loader');

    if (loader) {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 250);
    }
};

/* Initial website load */
window.addEventListener('load', hideLoader);

/* Inertia page navigation */
router.on('start', showLoader);
router.on('finish', hideLoader);

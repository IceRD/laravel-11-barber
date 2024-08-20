import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from "ziggy"

// Quasar Framework
// https://quasar.dev/components
import { Quasar, Notify } from "quasar"
import "@quasar/extras/roboto-font/roboto-font.css"
import "@quasar/extras/material-icons/material-icons.css"
import "quasar/src/css/index.sass"

// Дополнительные глобальные стили партнера
import "@partner/styles/app-variables.css"
// Глобальная стилизация элементов и классы
import '../css/app.scss';
// Глобальная js скрипты
import './bootstrap';

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Quasar, {
                plugins: { Notify },
                config: {
                    brand: {}
                }
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

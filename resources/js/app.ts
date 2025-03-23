import '../css/app.css'
import 'vue-select/dist/vue-select.css'

import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import type { DefineComponent } from 'vue'
import { createApp, h } from 'vue'
import { ZiggyVue } from 'ziggy-js'

import vSelect from 'vue-select'

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string
        [key: string]: string | boolean | undefined
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Link', Link)
            .component('Head', Head)
            .component('v-select', vSelect)
            .mount(el)
    },
    progress: {
        color: '#4B5563',
    },
})

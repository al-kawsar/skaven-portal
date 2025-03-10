import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/vue3";
import { ZiggyVue, route } from "ziggy-js";

import PrimeVue from "primevue/config";
import Ripple from "primevue/ripple";
import "primeicons/primeicons.css";
import ToastService from "primevue/toastservice";
import Aura from "@primevue/themes/aura";

createInertiaApp({
    progress: {
        color: "#3B82F6",

        includeCSS: true,

        showSpinner: true,
    },
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .use(ZiggyVue)
            .use(ToastService)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: "p",
                        darkModeSelector: "light",
                        cssLayer: {
                            name: "primevue",
                            order: "tailwind-base, primevue, tailwind-utilities",
                        },
                    },
                },
            })
            .component("Link", Link)
            .component("Head", Head)
            .directive("ripple", Ripple)
            .mount(el);
    },
});

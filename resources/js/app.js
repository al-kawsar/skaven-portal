import { createApp, h } from "vue";
import { createInertiaApp, Link, Head } from "@inertiajs/vue3";

import PrimeVue from "primevue/config";
import Lara from "@primevue/themes/lara";
import Ripple from "primevue/ripple";
import "primeicons/primeicons.css";
import { ZiggyVue, route } from "ziggy-js";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .use(ZiggyVue)
            .use(PrimeVue, {
                ripple: true,
                theme: {
                    preset: Lara,
                    options: {
                        prefix: "p",
                        darkModeSelector: "light",
                        cssLayer: false,
                    },
                },
            })
            .component("Link", Link)
            .component("Head", Head)
            .directive("ripple", Ripple)
            .mount(el);
    },
});

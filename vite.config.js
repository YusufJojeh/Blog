// vite.config.js
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwind from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwind(),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // so @import "bootstrap" works out of the box:
                includePaths: ["node_modules"],
                // silences ALL deprecation warnings coming from dependencies:
                quietDeps: true,
                // (optional) only mute the “mixed-decls” message if you want to see other deprecations:
                silenceDeprecations: ["mixed-decls"],
                //
                // if for some reason that doesn’t catch it, you can nest under `sassOptions` instead:
                //
                // sassOptions: {
                //   quietDeps: true,
                //   silenceDeprecations: ['mixed-decls'],
                // },
            },
        },
    },
});

import fs from "fs"
import path from "path"
import { defineConfig, loadEnv } from "vite"
import laravel from "laravel-vite-plugin"
import vue from "@vitejs/plugin-vue"
import { quasar, transformAssetUrls } from "@quasar/vite-plugin"

export default ({ mode }) => {
    process.env = {...process.env, ...loadEnv(mode, process.cwd())};

    const partner = process.env.VITE_APP_PARTNER

    try {
        // Копируем изображения для партнера в public
        const src = path.resolve(__dirname, "resources", "_partners", partner, "images")
        const dest = path.resolve(__dirname, "public", "assets", "images")
        fs.cpSync(src, dest, { recursive: true });
    } catch (error) {
        console.log(error.message);
    }

    return defineConfig({
        resolve: {
            alias: {
                "ziggy": path.resolve(__dirname, "vendor", "tightenco", "ziggy"),

                "@": path.resolve(__dirname, "resources", "js"),
                "@layouts": path.resolve(__dirname, "resources", "js", "Layouts"),
                "@components": path.resolve(__dirname, "resources", "js", "Components"),
                "@utils": path.resolve(__dirname, "resources", "js", "utils"),
                "@partner": path.resolve(__dirname, "resources", "_partners", partner),
            },
        },
        plugins: [
            laravel({
                input: path.resolve(__dirname, "resources", "js", "app.js"),
                refresh: true,
            }),
            vue({
                template: {
                    transformAssetUrls: { transformAssetUrls },
                },
            }),
            quasar({
                sassVariables: path.resolve(__dirname, "resources", "_partners", partner, "styles", "quasar.variables.sass"),
            })
        ],
    });
}

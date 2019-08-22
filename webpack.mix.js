const mix = require('laravel-mix');
const path = require('path')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/legacy-app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/service-worker.js', 'public/js')

    .webpackConfig({
        output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
        resolve: {
        alias: {
            // vue$: 'vue/dist/vue.runtime.esm.js',
            '@': path.resolve('resources/js'),
        },
        },
    })

    .babelConfig({
        plugins: ['@babel/plugin-syntax-dynamic-import'],
    })

    .sass('resources/sass/theme/dark/index.scss', 'public/css/theme-dark.css')
    .sass('resources/sass/theme/light/index.scss', 'public/css/theme-light.css')
    // .sass('resources/sass/theme/bunker/index.scss', 'public/css/theme-bunker.css')

    .options({
        processCssUrls: false
    })

    // Copies reused resources
    .copyDirectory('resources/img', 'public/img')
    .copyDirectory('resources/audio', 'public/audio')
    .copyDirectory('resources/video', 'public/video')
    .copyDirectory('resources/svg', 'public/svg')
    .copyDirectory('resources/vendor', 'public/vendor')
    .copyDirectory('resources/public', 'public/')

    .version()
;

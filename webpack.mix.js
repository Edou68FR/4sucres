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

    .postCss('resources/css/main.css', 'public/css', [
        require('postcss-import'),
        require('postcss-calc'),
        require('postcss-url'),
        require('tailwindcss'),
        require('postcss-nested'),
        // Reduces the weight of outputed CSS files
        // To avoid cache issues while developping, better activate this before
        // launching to production
        // require('@fullhuman/postcss-purgecss')({
        //     content: [
        //         './templates/**/*.blade.php',
        //         './assets/js/**/*.vue'
        //     ]
        // }),
        require('autoprefixer')({}),
    ])

    // Copies reused resources
    .copyDirectory('resources/img', 'public/img')
    .copyDirectory('resources/audio', 'public/audio')
    .copyDirectory('resources/video', 'public/video')
    .copyDirectory('resources/svg', 'public/svg')
    .copyDirectory('resources/vendor', 'public/vendor')
    .copyDirectory('resources/public', 'public/')

    .version()
;

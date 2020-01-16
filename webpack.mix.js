let mix = require('laravel-mix');

let webpackAlias = require('./build/webpack.alias.js')

let webpackConfig = {
    resolve: {
        alias: webpackAlias
    }
}

mix.copyDirectory('resources/images', 'public/img')
    .js('resources/assets/js/backend/app.js', 'public/js/backend.js')
    .js('resources/assets/js/frontend/app.js', 'public/js/frontend.js')
    .sass('resources/assets/sass/backend/app.scss', 'public/css/backend.css')
    .sass('resources/assets/sass/frontend/app.scss', 'public/css/frontend.css')
    .extract(['vue','vue-router','moment','axios','lodash'])
    // Additional webpack configuration
    .webpackConfig(webpackConfig);

if (process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}

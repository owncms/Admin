const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/admin.js')
    .js(__dirname + '/Resources/assets/js/base_admin.js', 'js/base_admin.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/admin.css');

if (mix.inProduction()) {
    mix.version();
}

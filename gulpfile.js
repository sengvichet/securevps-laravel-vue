const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');
require('laravel-elixir-browsersync-official');
// require('laravel-elixir-webpack-official');
// var gulp  = require('gulp');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


elixir(mix => {

    mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/fonts/bootstrap');

    mix.sass('vendor.scss');
    mix.sass('app.scss');
    mix.sass('admin.scss');

    mix.scripts([
        'vendor/jquery.js',
        'vendor/what-input.min.js',
        'foundation.min.js',
        'vendor/hoverIntent.js',
        'vendor/superfish.min.js',
        'vendor/morphext.min.js',
        'vendor/wow.min.js',
        'vendor/jquery.slicknav.min.js',
        'vendor/waypoints.min.js',
        'vendor/jquery.animateNumber.min.js',
        'vendor/owl.carousel.min.js',
        'vendor/retina.min.js',
        'custom.js',
    ], 'public/js/vendor.js');

    mix.webpack('app.js');

    mix.browserSync({
        proxy: 'shev.web',
        host: '192.168.10.10',
        open: false
    });

});

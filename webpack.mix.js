const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles([
      'public/template/css/bootstrap.css',
      'public/template/css/main.css',
      'public/template/css/all.css',
   ], 'public/css/main.css')
   .scripts([
      'public/template/js/jquery.min.js',
      'public/template/js/popper.min.js',
      'public/template/js/bootstrap.min.js',
      'public/template/js/chartjs.min.js',
      'public/template/js/font-awesome.min.js',
      'public/template/js/main.js',
   ], 'public/js/main.js');

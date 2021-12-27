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

mix.js('resources/js/app.js', 'public/js/app.js')
   .js('resources/js/cdm/app.js', 'public/js/cdm/app.js')   
   .js('resources/js/reportes/app.js', 'public/js/reportes/app.js')   
   .js('resources/js/administracion/app.js', 'public/js/administracion/app.js')
   .js('resources/js/culturas/app.js', 'public/js/culturas/app.js')
   .sass('resources/sass/app.scss', 'public/css')
   .js('resources/js/organizaciones/app.js', 'public/js/organizaciones/app.js')
   .js('resources/js/nidos/app.js', 'public/js/nidos/app.js')
   .js('resources/js/infraestructura/app.js', 'public/js/infraestructura/app.js');
let mix = require('laravel-mix');

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

let theme = process.env.PRESS_THEME || 'clean-blog';

mix
	.setPublicPath('public')
    .js('resources/js/app.js', 'js/press.js');

mix
	.setPublicPath('public/' + theme)
    .copyDirectory('./node_modules/startbootstrap-clean-blog/img', 'public/' + theme + '/img')
    .js('resources/templates/'+ theme + '/js/app.js', 'js')
	.sass('resources/templates/'+ theme + '/sass/app.scss', 'css');

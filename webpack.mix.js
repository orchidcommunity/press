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
//mix.setPublicPath(path.normalize('public/' + theme));
mix.setPublicPath(path.normalize('public'));

mix
    .sass('resources/sass/app.scss', 'css/press.css')
    .js('resources/js/app.js', 'js/press.js')
    .copyDirectory('./node_modules/startbootstrap-clean-blog/img', 'public/' + theme + '/img')
    .js('resources/templates/'+ theme + '/js/app.js', theme + '/js')
	.sass('resources/templates/'+ theme + '/sass/app.scss', theme + '/css');

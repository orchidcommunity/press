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
mix.setPublicPath('public/' + theme);

mix
	//.copy('./node_modules/font-awesome/fonts/', 'public/fonts')
	//.copy('./resources/assets/fonts/', 'public/fonts')
	//.js('resources/assets/js/bsblog/app.js', 'js/bsblog')
	//.sass('resources/assets/sass/bsblog/app.scss', 'css/bsblog')
    .copyDirectory('./node_modules/startbootstrap-clean-blog/img', 'public/' + theme + '/img')
    .js('resources/assets/'+ theme + '/js/app.js', 'js')
	.sass('resources/assets/'+ theme + '/sass/app.scss', 'css');

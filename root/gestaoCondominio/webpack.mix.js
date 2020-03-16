const mix = require('laravel-mix');

mix.options({ processCssUrls: false });

mix.sass('resources/assets/sass/app.scss', 'public/css');

mix.copy('node_modules/font-awesome/fonts','public/fonts');
mix.copy('resources/assets/fonts','public/fonts');
mix.copy('resources/assets/images','public/images');
mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap','public/fonts/bootstrap/');

mix.js("resources/assets/js/main.js", 'public/js/all.js');

if (mix.inProduction()) {
    mix.version(['public/css/app.css', 'public/js/all.js']);
}

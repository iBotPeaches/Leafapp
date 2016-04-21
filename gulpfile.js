var elixir = require('laravel-elixir');

var paths = {
    'jquery': './node_modules/jquery/dist/',
    'resources': './resources/'
};

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

elixir(function(mix) {
    mix
        .copy(paths.jquery + 'jquery.min.js', 'public/js/jquery.min.js')
        .copy(paths.resources + 'themes', 'public/themes/')
        .styles([
            'semantic.css',
            'app.css'
        ], "public/css/app.css")
        .scripts([
            'semantic.js'
        ], "public/js/app.js")
        .version(["public/css/app.css", "public/js/app.js"]);
});
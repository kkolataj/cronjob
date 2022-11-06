const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/build/assets/')
    .vue()
    .postCss('resources/css/app.css', 'public/build/assets/')
    .browserSync('http://127.0.0.1:8000');

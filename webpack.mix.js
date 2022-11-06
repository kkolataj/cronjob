const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/build/assets/.*js')
    .vue()
    .postCss('resources/css/app.css', 'public/build/assets/.*css')
    .browserSync('http://127.0.0.1:8000');

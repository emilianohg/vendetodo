const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [])
    .postCss('resources/css/pages/productos-create.css', 'public/css', [])
.postCss('resources/css/pages/productos-index.css', 'public/css', []);

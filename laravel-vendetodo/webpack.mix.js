const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [])
    .postCss('resources/css/pages/productos-create.css', 'public/css', [])
    .postCss('resources/css/pages/login.css', 'public/css', [])
    .postCss('resources/css/pages/perfil.css', 'public/css', [])
    .postCss('resources/css/pages/productos-index.css', 'public/css', [])
    .postCss('resources/css/pages/productos-individual.css', 'public/css', [])
    .postCss('resources/css/pages/carrito.css', 'public/css', [])
    .postCss('resources/css/pages/estante-dashboard.css','public/css', [])
    .postCss('resources/css/pages/compra-detalle.css','public/css', [])
    .postCss('resources/css/pages/compra-success.css','public/css', []);
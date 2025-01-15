const mix = require('laravel-mix');

// Mengompilasi JavaScript dan CSS
mix.js('resources/js/index.js', 'public/js') 
    .js('resources/js/chat.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
    ])
    .version();

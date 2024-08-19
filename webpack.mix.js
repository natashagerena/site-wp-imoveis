const mix = require('laravel-mix');

// JS
mix.scripts([
    'src/js/libs/*.js',
    'src/js/main.js',
], 'assets/js/app.min.js');

// Sass
mix.sass('src/styles/main.scss', 'assets/css/app.css').options({
    processCssUrls: false
});

// BrowserSync
mix.browserSync({
    proxy: 'site-imoveis.test',
    ui: false,
    files: [
        './assets/**/*',
        './views/*.twig',
        './**/*.php',
    ]
});

// Disable notifications
mix.disableNotifications();
